<?php
/**
 * Novalnet payment method module
 * 
 * This module is used for real time processing of Novalnet transaction of customers.
 *
 *
 * This free contribution made by request.
 * If you have found this script useful a small
 * recommendation as well as a comment on merchant
 * form would be greatly appreciated.
 * 
 * @author    Novalnet AG
 * @copyright Copyright by Novalnet
 * @license   https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 *
 * Script : novalnet_paypal.php
 */

class ControllerExtensionPaymentNovalnetPaypal extends Controller
{
    private $json = array();

    private $payment_method = 'novalnet_paypal';

    /**
     * Initiate payment process
     *
     * @param       none
     * @return      none
     */
    public function index()
    {
        // Load language.
        $this->language->load('extension/payment/novalnet_paypal');

        // Load Novalnet model.
        $this->load->model('extension/payment/novalnet');

        // Assign basic details.
        $data = $this->model_extension_payment_novalnet->getBasicDetails('payment_novalnet_paypal');

        // Get one click shopping details.
        
        $data = $this->model_extension_payment_novalnet->getShoppingTypeDetails('novalnet_paypal',
        $data);

        // Add language content.
        $data = $this->getLanguageContent($data);
        
        $data['oneclick']=$this->config->get('payment_novalnet_paypal_shopping_type');

        // Add template.
        return $this->load->view('extension/payment/novalnet_paypal', $data);
    }

    /**
     * Perform order confirmation process
     *
     * @param       none
     * @return      none
     */
    public function confirm()
    {
        // Load language.
        $this->language->load('extension/payment/novalnet_paypal');

        // Load model.
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/novalnet');

        $shopping_type = $this->config->get('payment_novalnet_paypal_shopping_type');
        

        // Build Basic parameters.
        $parameters = $this->model_extension_payment_novalnet->getParameters('novalnet_paypal');
        
        // Build one click form parameters.
        if($this->config->get('payment_novalnet_paypal_shopping_type')=='ONE_CLICK'){
         $customer_one_click=$this->request->request['customer_oneclick'];
         
        }else{
        $customer_one_click=$this->request->request['customer_oneclick']='False';
        }
        $parameters = $this->model_extension_payment_novalnet->formOneClickParams($parameters, 'novalnet_paypal', $shopping_type,$customer_one_click);

        $parameters = $this->model_extension_payment_novalnet->zeroBookingParams($parameters, $shopping_type, 'novalnet_paypal');

        
        if($shopping_type != 'ZERO_AMOUNT'){
            $parameters = $this->model_extension_payment_novalnet->getOnholdParameter($parameters, $parameters['amount'], 'payment_novalnet_paypal');
        }

        if(($shopping_type != 'ONE_CLICK' && $this->request->request['customer_oneclick']!='True') || (  $shopping_type == 'ONE_CLICK' && !empty($parameters['create_payment_ref']))||$this->request->request['customer_oneclick']=='False') {      
            // Build Third party parameters.
            $parameters = $this->model_extension_payment_novalnet->getRedirectParameters($parameters, 'novalnet_paypal');
            
            // Redirect to Novalnet server.
            $this->json = $this->model_extension_payment_novalnet->performRedirectProcess($this->model_extension_payment_novalnet->getUrl('paypal'), $parameters, 'novalnet_paypal');
            echo json_encode($this->json);
            exit();
        } elseif($this->request->request['customer_oneclick']=='True') {
            $this->session->data['novalnet_paypal_reference_tid'] = $parameters['payment_ref'];
            $server_response = $this->model_extension_payment_novalnet->performPaymentCall($parameters);

            if(!empty($server_response['status']) && $server_response['status'] == '100') {
                $server_response['additional_details'] = $server_response['one_click_details'] = $server_response['create_payment_ref'] = '';
                $data = $this->model_extension_payment_novalnet->transactionSuccess($server_response, 'novalnet_paypal');
                $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $data['orderStatus'], $this->db->escape($data['novalnet_comments']), true);
                $this->json['success'] = $this->url->link('checkout/success');
            } else {
                $this->json['error'] = $this->model_extension_payment_novalnet->setResponseMessage($server_response);
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($this->json));
            return false;
        }
    }

    public function callback() { 
        // Load model.
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/novalnet');
        $this->language->load('extension/payment/' . $this->payment_method);
        $server_response  = $this->model_extension_payment_novalnet->checkRedirectPaymentProcess($this->payment_method);
        if (!empty($server_response['type']) && $server_response['type'] == 'failure') {
            $this->session->data['error'] = $server_response['error'];
            $this->response->redirect($this->url->link('checkout/checkout'));
        } else {

            // Check and store one click process informations.
            if (!empty($server_response['create_payment_ref']) && ($this->config->get('payment_novalnet_paypal_shopping_type') == 'ONE_CLICK')) {
                $server_response['additional_details'] = json_encode(array(
                    'paypal_transaction_id' => $server_response['paypal_transaction_id'],
                    'tid'                   => $server_response['tid'],
                ));
                $server_response['one_click_details'] = json_encode(array(
                    'parent_tid' => $server_response['tid'],
                ));
            }

            $data  = $this->model_extension_payment_novalnet->transactionSuccess($server_response, $this->payment_method);
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $data['orderStatus'], $this->db->escape($data['novalnet_comments']), true);
            $this->response->redirect($this->url->link('checkout/success'));
        }
    }

    /**
     * Get language content from language file.
     *
     * @param       $data
     * @return      none
     */
    public function getLanguageContent($data) {
        foreach (array(
           'text_payment_description',
            'text_test_mode_description',
            'text_browser_description',
            'button_confirm',
            'novalnet_paypal_new_payment_details',
            'novalnet_paypal_placed_payment_details',
            'novalnet_paypal_transaction_id',
            'zero_amount_desc',
            'novalnet_paypal_novalnet_tid',
            'text_guarantee_payment_reference_transaction',
            'text_title',
            'save_card_details',
            'text_order_processed',
        ) as $value) {
            $data[$value] = $this->language->get($value);
        }
        return $data;
    }
}
