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
 * Script : novalnet_sepa.php
 */

class ControllerExtensionPaymentNovalnetSepa extends Controller
{

    private $json = array();

    /**
     * Initiate payment process
     *
     * @param       none
     * @return      none
     */
    public function index()
    {
        // Load language content.
        $this->language->load('extension/payment/novalnet_sepa');

        // Load Novalnet model.
        $this->load->model('extension/payment/novalnet');

        $this->load->model('checkout/order');

        // Load Order information.
        $order_info          = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        // Assign basic details.
        $data = $this->model_extension_payment_novalnet->getBasicDetails('payment_novalnet_sepa');

        // Get one click shopping details.
        $data = $this->model_extension_payment_novalnet->getShoppingTypeDetails('novalnet_sepa', $data);

        // Get Guarantee details.
        $data = $this->model_extension_payment_novalnet->getGuaranteeDetails('payment_novalnet_sepa', $order_info, $data);

        // Add Direct Debit SEPA additional details.
        $data = $this->sepaDetails($data, $order_info);
           
        // Add language content.
        $data = $this->getLanguageContent($data);
        
        // one_click customer_verification
        $data['one_click']=$this->config->get('payment_novalnet_sepa_shopping_type');

        // Add template.
        return $this->load->view('extension/payment/novalnet_sepa', $data);
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
        $this->language->load('extension/payment/novalnet_sepa');
        // Load model.
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/novalnet');
		// Get shopping type value.
		$shopping_type = $this->config->get('payment_novalnet_sepa_shopping_type');
		$this->json['error'] = '';
		if(!empty($this->session->data['novalnet_sepa_max_time'])){
			$this->json['error'] = $this->session->data['novalnet_sepa_status_text'];
		}
		// Validate for guarantee process.
		$this->json['error'] = empty($this->json['error']) ? $this->model_extension_payment_novalnet->validateGuaranteeProcess('novalnet_sepa') : $this->json['error'];
		// Proceed validation process.
		if (!empty($this->json['error'])) {
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($this->json));
			return false;
		}
		// Build Basic parameters.
		 $parameters = $this->model_extension_payment_novalnet->getParameters('novalnet_sepa');
		 $parameters['iban']=$this->request->request['novalnet_sepa_account_no'];             
		// Build one click form parameters.
		if($this->config->get('payment_novalnet_sepa_shopping_type')=='ONE_CLICK') {
			$customer_one_click=$this->request->request['customer_oneclick'];
		} else {
			$customer_one_click=$this->request->request['customer_oneclick']='False';
		}
		$parameters = $this->model_extension_payment_novalnet->formOneClickParams($parameters, 'novalnet_sepa', $shopping_type,$customer_one_click);    
		// Form guarantee payment parameters.
		$parameters = $this->model_extension_payment_novalnet->formGuaranteePaymentParams($parameters, 'payment_novalnet_sepa');
		// Build zero amount booking parameters.
		if($parameters['key'] == '37'){
			$parameters = $this->model_extension_payment_novalnet->zeroBookingParams($parameters, $shopping_type, 'novalnet_sepa');
		}
		// Check for on-hold transaction.
		$parameters = $this->model_extension_payment_novalnet->getOnholdParameter($parameters, $parameters['amount'], 'payment_novalnet_sepa');
		
		// Form due date.
		$sepa_due_date = !empty($this->config->get('payment_novalnet_sepa_due_date')) ? (trim($this->config->get('payment_novalnet_sepa_due_date'))) : '';
		if(!empty($sepa_due_date))
		$parameters['sepa_due_date'] = date('Y-m-d', mktime(0, 0, 0, date('m'), (date('d') + $sepa_due_date), date('Y')));
		
		if(empty($parameters['payment_ref'])) {                             
			$required_param = array('novalnet_sepa_holder');                
			if($shopping_type = 'ONE_CLICK' && $this->request->request['novalnet_sepa_one_click_shopping'] != '1'){
			$required_param = array('novalnet_sepa_holder');                
			}               
			$this->json['error'] = $this->model_extension_payment_novalnet->validatePaymentFields($required_param, 'novalnet_sepa');
			if (!empty($this->json['error'])) {
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($this->json));
				return false;
			}
			$parameters['bank_account_holder']    = trim($this->request->request['novalnet_sepa_holder']);
		} else { 
			$this->session->data['novalnet_sepa_reference_tid'] = $parameters['payment_ref'];
		}
        // Perform payment call.
        $server_response = $this->model_extension_payment_novalnet->performPaymentCall($parameters);
        // Check for valid response.
        if($this->model_extension_payment_novalnet->checkResponseStatus($server_response)) {
            $server_response['additional_details'] = $server_response['one_click_details'] = $server_response['create_payment_ref'] = '';
            // Check and store one click process informations.
            if($this->config->get('payment_novalnet_sepa_shopping_type') == 'ONE_CLICK') {
            if (empty($parameters['payment_ref']) && $this->request->request['customer_oneclick']=='True') {
                $server_response['additional_details'] = json_encode(array(
                    'account_holder' => $server_response['bankaccount_holder'],
                    'iban' => $server_response['iban'],
                ));
                $server_response['one_click_details'] = json_encode(array(
                    'parent_tid' => $server_response['tid'],
                ));
                $server_response['create_payment_ref'] = 1;
            }
        }
            $data = $this->model_extension_payment_novalnet->transactionSuccess($server_response, 'novalnet_sepa');
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $data['orderStatus'], $this->db->escape($data['novalnet_comments']), true);
            $this->json['success'] = $this->url->link('checkout/success');
            $this->model_extension_payment_novalnet->unsetSessionValues('payment_novalnet_sepa');
        } else {
            $this->json['error'] = $this->model_extension_payment_novalnet->setResponseMessage($server_response);
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($this->json));
        return false;
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
            'text_sepa_account_holder',
            'text_sepa_account_no',
            'button_confirm',
            'text_title',
            'novalnet_sepa_payment_details_error',
            'novalnet_sepa_new_account_details',
            'novalnet_sepa_given_account_details',
            'text_guarantee_payment_dob',
            'text_order_processed'
        ) as $value) {
            $data[$value] = $this->language->get($value);
        }
        return $data;
    }

     /**
     * Get sepa details.
     *
     * @param       $data
     * @param       $order_info
     * @return      none
     */
    public function sepaDetails($data, $order_info) {
        // Assign form default values.
        $data['account_holder']       = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
        $data['company'] = !empty($order_info['payment_company']) ? trim($order_info['payment_company']) : '';
        $data['remote_ip'] = $this->model_extension_payment_novalnet->getIpAddress('REMOTE_ADDR');
        return $data;
    }
}
