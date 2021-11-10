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
 * Script : novalnet_cc.php
 */

class ControllerExtensionPaymentNovalnetCc extends Controller
{
    private $json = array();

    private $payment_method = 'novalnet_cc';

    /**
     * Initiate payment process
     *
     * @param       none
     * @return      none
     */
    public function index()
    {
        // Load language content.
        $this->language->load('extension/payment/novalnet_cc');

        // Load Novalnet model.
        $this->load->model('extension/payment/novalnet');

        // Assign basic details.
        $data = $this->model_extension_payment_novalnet->getBasicDetails('payment_novalnet_cc');

        // Get one click shopping details.
        $data = $this->model_extension_payment_novalnet->getShoppingTypeDetails($this->payment_method, $data);
        $data['oneclick']= $this->config->get('payment_novalnet_cc_shopping_type');     
        
        // Add Credit Card additional details.
        $data = $this->ccDetails($data);

        // Add language content.
        $data = $this->getLanguageContent($data);

        // Add Iframe style content.
        $data = $this->getIframeStyleContent($data);
        
        // Add template.
        return $this->load->view('extension/payment/novalnet_cc', $data);
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
        $this->language->load('extension/payment/novalnet_cc');

        // Load model.
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/novalnet');

        // Get shopping type value.
        $shopping_type = $this->config->get('payment_novalnet_cc_shopping_type');   
       if($this->config->get('payment_novalnet_cc_shopping_type')=='ONE_CLICK' && $this->config->get('payment_novalnet_cc_3d_enable') != 'yes' && $this->config->get('payment_novalnet_cc_force_3d_enable') != 'yes'){
            $customer_one_click=$this->request->request['customer_oneclick'];
        }else{
            $customer_one_click=$this->request->request['customer_oneclick'] = 'False';
        }
        if (!empty($this->json['error'])) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($this->json));
            return false;
        }

        // Build Basic parameters.
        $parameters = $this->model_extension_payment_novalnet->getParameters('novalnet_cc');

        // Build one click form parameters.
        $parameters = $this->model_extension_payment_novalnet->formOneClickParams($parameters, 'novalnet_cc', $shopping_type,$customer_one_click);

        // Build zero amount booking parameters.
        $parameters = $this->model_extension_payment_novalnet->zeroBookingParams($parameters, $shopping_type, 'novalnet_cc');

        // Check for on-hold transaction.
        $parameters = $this->model_extension_payment_novalnet->getOnholdParameter($parameters, $parameters['amount'], 'payment_novalnet_cc');

        if(empty($parameters['payment_ref'])) {
            
            // Validate payment details.
            $this->json['error'] = $this->model_extension_payment_novalnet->validatePaymentFields(array(
                'cc_panhash',
                'cc_unique_id',
            ), 'novalnet_cc');

            if (!empty($this->json['error'])) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->setOutput(json_encode($this->json));
                return false;
            }
            $parameters['pan_hash']                   = $this->request->request['cc_panhash'];
            $parameters['unique_id']                  = $this->request->request['cc_unique_id'];
        } else {
            $this->session->data['novalnet_cc_reference_tid'] = $parameters['payment_ref'];
        }

        // Check for 3D secure transaction.
        if($this->config->get('payment_novalnet_cc_3d_enable') == 'yes' || $this->config->get('payment_novalnet_cc_force_3d_enable') == 'yes') {
            $parameters = $this->model_extension_payment_novalnet->getRedirectParameters($parameters, 'novalnet_cc');
            if($this->config->get('payment_novalnet_cc_3d_enable') == 'yes') {
                $parameters['cc_3d'] = 1;
            }

            if ($shopping_type != 'ZERO_AMOUNT') {
                unset($parameters['create_payment_ref']);
            }

            unset($parameters['user_variable_0']);
            // Form hidden values.
            $this->json = $this->model_extension_payment_novalnet->performRedirectProcess($this->model_extension_payment_novalnet->getUrl('pci_payport'), $parameters, 'novalnet_cc');
            echo json_encode($this->json);
            exit();
        }
        $parameters['nn_it'] = 'iframe';
       
        // Perform Novalnet payment request.               
        $server_response = $this->model_extension_payment_novalnet->performPaymentCall($parameters);        
       
        if($this->model_extension_payment_novalnet->checkResponseStatus($server_response)) {
            $server_response['additional_details'] = $server_response['one_click_details'] = $server_response['create_payment_ref'] = '';
     
            if (empty($parameters['payment_ref']) && ($this->config->get('payment_novalnet_cc_shopping_type') == 'ONE_CLICK'&& $this->request->request['customer_oneclick']=='True')) {
                
                    $server_response['additional_details'] = json_encode(array(
                    'cc_holder'    => $server_response['cc_holder'],
                    'cc_card_type' => $server_response['cc_card_type'],
                    'cc_no'        => $server_response['cc_no'],
                    'cc_exp_year'  => $server_response['cc_exp_year'],
                    'cc_exp_month' => $server_response['cc_exp_month'],
                    'pan_hash'     => $this->request->request['cc_panhash'],
                    'unique_id'    => $this->request->request['cc_unique_id'],
                ));
                $server_response['one_click_details'] = json_encode(array(
                    'parent_tid' => $server_response['tid'],
                ));
                $server_response['create_payment_ref'] = 1;
            }

            $data = $this->model_extension_payment_novalnet->transactionSuccess($server_response, 'novalnet_cc');
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $data['orderStatus'], $this->db->escape($data['novalnet_comments']), true);
            $this->json['success'] = $this->url->link('checkout/success');
        } else {
            $this->json['error'] = $this->model_extension_payment_novalnet->setResponseMessage($server_response);
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($this->json));
        return false;
    }

    /**
     * Get server response details
     *
     * @param       none
     * @return      none
     */
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
            $data  = $this->model_extension_payment_novalnet->transactionSuccess($server_response, $this->payment_method);
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $data['orderStatus'], $this->db->escape($data['novalnet_comments']), true);
            $this->response->redirect($this->url->link('checkout/success'));
        }
    }
    
    /**
     * Get CC details
     *
     * @param       none
     * @return      none
     */
    public function ccDetails($data) {

        // Form api signature.
        $api_signature = base64_encode(trim('vendor='.$this->config->get('payment_novalnet_merchant_id')) . '&' .'product='. $this->config->get('payment_novalnet_project_id'). '&' . 'server_ip='.$this->model_extension_payment_novalnet->getIpAddress('SERVER_ADDR'));
        
        $shopping_type = $this->config->get('payment_novalnet_cc_shopping_type');        

        // Form Iframe source URL.
        $data['iframe_src'] = 'https://secure.novalnet.de/cc?api=' . $api_signature . '&ln=' . $this->model_extension_payment_novalnet->getLanguageCode($this->session->data['language']);  
        
        // Assign description Based on 3d secure enable.
        $data['payment_description'] = $this->language->get('text_direct_payment_description');
        if($this->config->get('payment_novalnet_cc_3d_enable') == 'yes' || $this->config->get('payment_novalnet_cc_force_3d_enable') == 'yes') {
            $data['one_click_process_enabled'] = false;
            $data['new_details_style']    = 'display:block';
            $data['payment_description'] = $this->language->get('text_payment_description') . '<br/>' . $this->language->get('text_browser_description');
        }

        $data['shopping_type'] = $shopping_type;
        // Display Payment logo.
        $data['amex_logo'] = '';
        $data['maestro_logo'] = '';
        if($this->config->get('payment_novalnet_payment_logo') == 1) {
            $data['amex_logo'] = ($this->config->get('payment_novalnet_cc_display_amex') == 'yes') ? $this->language->get('amex_logo') : '';
            $data['maestro_logo'] = ($this->config->get('payment_novalnet_cc_display_maestro') == 'yes') ? $this->language->get('maestro_logo') : '';
        }
        return $data;
    }

    /**
     * Get language content from language file.
     *
     * @param       $data
     * @return      none
     */
    public function getIframeStyleContent($data) {

        foreach(array(
            'cc_iframe_standard_label',
            'cc_iframe_standard_input',
            'cc_iframe_standard_css_text',
        ) as $v ){
            $data[$v] = $this->config->get('payment_novalnet_' . $v);
        }
        return $data;
    }

    /**
     * Get language content from language file.
     *
     * @param       $data
     * @return      none
     */
    public function getLanguageContent($data) {
        foreach (array(
            'text_cc_card_name',
            'text_cc_date_placeholder',
            'text_cc_cvc_placeholder',
            'novalnet_cc_payment_details_error',
            'text_payment_description',
            'text_direct_payment_description',
            'text_test_mode_description',
            'zero_amount_desc',
            'text_cc_holder',
            'text_cc_cvc_hint',
            'text_cc_number',
            'text_cc_expiry_date',
            'text_cc_cvc',
            'button_confirm',
            'text_title',
            'novalnet_cc_new_card_details',
            'novalnet_cc_given_card_details',
            'text_cc_type',
            'text_browser_description',
            'save_card_details',
            'text_order_processed'
        ) as $value) {
            $data[$value] = $this->language->get($value);
        }
        return $data;
    }
}
