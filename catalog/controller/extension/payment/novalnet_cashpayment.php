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
 * Script : novalnet_cashpayment.php
 */

class ControllerExtensionPaymentNovalnetCashpayment extends Controller
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
		$this->language->load('extension/payment/novalnet_cashpayment');
		// Load Novalnet model.
		$this->load->model('extension/payment/novalnet');
		// Assign basic details.
		$data = $this->model_extension_payment_novalnet->getBasicDetails('payment_novalnet_cashpayment');
		// Add language content.
		$data = $this->getLanguageContent($data);
		// Add template.
		return $this->load->view('extension/payment/novalnet_cashpayment', $data);
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
		$this->language->load('extension/payment/novalnet_cashpayment');
		// Load model.
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/novalnet');
		// Build Basic parameters.
		$parameters = $this->model_extension_payment_novalnet->getParameters('novalnet_cashpayment');			
		
		// Form due date.
		$cashpaymet_duedate = trim($this->config->get('payment_novalnet_cashpayment_slip_expiry_date'));
		if (!empty($cashpaymet_duedate)) {
			$parameters['cp_due_date'] = date('Y-m-d', mktime(0, 0, 0, date('m'), (date('d') + $cashpaymet_duedate), date('Y')));
		}
			
		// Perform payment call.
		$server_response = $this->model_extension_payment_novalnet->performPaymentCall($parameters);				
		// Validate paygate response.
		if($this->model_extension_payment_novalnet->checkResponseStatus($server_response)) {			
			$server_response['additional_details'] = json_encode(array(
				'cp_due_date' => $server_response['cp_due_date'],			
			));
			$this->session->data['nn_test_mode'] = $server_response['test_mode'];
            $this->session->data['cp_checkout_token'] = $server_response['cp_checkout_token'];
			$data = $this->model_extension_payment_novalnet->transactionSuccess($server_response, 'novalnet_cashpayment');
			// Generate Novalnet comments.
			$data['novalnet_comments'] .= $this->model_extension_payment_novalnet->prepareBarzahlenComments($server_response);
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $data['orderStatus'], $this->db->escape($data['novalnet_comments']), true);
			$this->json['success'] = $this->url->link('checkout/success');
		} else {
			$this->json['error'] = $this->model_extension_payment_novalnet->setResponseMessage($server_response);
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($this->json));
			return false;
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($this->json));
	}

	/**
	 * Get language content from language file.
	 *
	 * @param       $data
	 * @return      none
	 */
	public function getLanguageContent($data) {
		foreach (array(
			'text_barzahlen_payment_description',
			'text_test_mode_description',
			'button_confirm',
			'text_title',
			'text_order_processed',
		) as $value) {
			$data[$value] = $this->language->get($value);
		}
		return $data;
	}
}
