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
 * Script : novalnet_prepayment.php
 */

class ControllerExtensionPaymentNovalnetPrepayment extends Controller
{
	private $json = array();

	private $payment_method = 'novalnet_prepayment';
	/**
	 * Initiate payment process
	 *
	 * @param       none
	 * @return      none
	 */
	public function index()
	{
		// Load language content.
		$this->language->load('extension/payment/novalnet_prepayment');

		// Load Novalnet model.
		$this->load->model('extension/payment/novalnet');

		// Assign basic details.
		$data = $this->model_extension_payment_novalnet->getBasicDetails('payment_novalnet_prepayment');

		// Add language content.
		$data = $this->getLanguageContent($data);
      
		// Add template.
		return $this->load->view('extension/payment/novalnet_prepayment', $data);
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
		$this->language->load('extension/payment/novalnet_prepayment');

		// Load model.
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/novalnet');

		// Build Basic parameters.
		$parameters = $this->model_extension_payment_novalnet->getParameters('novalnet_prepayment');

		// Form payment parameters.
		$parameters['invoice_type'] = 'PREPAYMENT';
		$parameters['invoice_ref']  = 'BNR-' . $parameters['product'] . '-' . $parameters['order_no'];
		
		// Perform payment call.
		$server_response = $this->model_extension_payment_novalnet->performPaymentCall($parameters);

		// Validate paygate response.
		if($this->model_extension_payment_novalnet->checkResponseStatus($server_response)) {
			$server_response['additional_details'] = json_encode(array(
				'due_date'         	=> $server_response['due_date'],
				'invoice_iban'  	=> $server_response['invoice_iban'],
				'invoice_bic'  		=> $server_response['invoice_bic'],
				'invoice_bankname'  => $server_response['invoice_bankname'],
				'invoice_bankplace' => $server_response['invoice_bankplace'],
			));
			$data = $this->model_extension_payment_novalnet->transactionSuccess($server_response, 'novalnet_prepayment');

			// Generate Novalnet comments.
			$data['novalnet_comments'] .= $this->model_extension_payment_novalnet->prepareNovalnetComments($server_response, $data['order_info'], $this->payment_method, $this->session->data['order_id']);
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
			'text_payment_description',
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
