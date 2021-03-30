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
 * Script : novalnet_invoice.php
 */

class ControllerExtensionPaymentNovalnetInvoice extends Controller
{
	private $json = array();

	private $payment_method = 'novalnet_invoice';

	/**
	 * Initiate payment process
	 *
	 * @param       none
	 * @return      none
	 */
	public function index()
	{
		// Load language content.
		$this->language->load('extension/payment/novalnet_invoice');

		// Load Novalnet model.
		$this->load->model('extension/payment/novalnet');

		$this->load->model('checkout/order');

		// Get order details.
		$order_info          = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		// Assign basic details.
		$data = $this->model_extension_payment_novalnet->getBasicDetails('payment_novalnet_invoice');
        
		// Get fraud module details.
		$data = $this->model_extension_payment_novalnet->getFraudModuleDetails('payment_novalnet_invoice', $order_info, $data);

		// Get Guarantee details.
		$data = $this->model_extension_payment_novalnet->getGuaranteeDetails('payment_novalnet_invoice', $order_info, $data);

		// Check for PIN call.
		$data['process_pin_call']   = !empty($this->session->data['payment_novalnet_invoice']['tid']);
		
		$data['company'] = !empty($order_info['payment_company']) ? trim($order_info['payment_company']) : '';

		// Add Language content.
		$data = $this->getLanguageContent($data);		
		
		$data = array_map('trim', $data);

		// Add template.		
		return $this->load->view('extension/payment/novalnet_invoice', $data);
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
		$this->language->load('extension/payment/novalnet_invoice');

		// Load model.
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/novalnet');	
		
		if (empty($this->session->data['payment_novalnet_invoice']['tid'])) { 
			$this->json['error'] = '';

			if(!empty($this->session->data['novalnet_invoice_max_time'])){
				$this->json['error'] = $this->session->data['novalnet_invoice_status_text'];
			}

			// Validate for guarantee process.
			$this->json['error'] = empty($this->json['error']) ? $this->model_extension_payment_novalnet->validateGuaranteeProcess('novalnet_invoice') : $this->json['error'];

			// Validate for Callback process.
			$this->json['error'] = empty($this->json['error']) ? $this->model_extension_payment_novalnet->validateCallbackFields('payment_novalnet_invoice') : $this->json['error'];

			if (!empty($this->json['error'])) {
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($this->json));
				return false;
			}

			// Build Basic parameters.
			$parameters = $this->model_extension_payment_novalnet->getParameters('novalnet_invoice');

			// Form guarantee payment parameters.
			$parameters = $this->model_extension_payment_novalnet->formGuaranteePaymentParams($parameters, 'payment_novalnet_invoice');
			
			// Check for on-hold transaction.
			$parameters = $this->model_extension_payment_novalnet->getOnholdParameter($parameters, $parameters['amount'], 'payment_novalnet_invoice');

			// Form fraud module parameters.
			$parameters = $this->model_extension_payment_novalnet->formFraudModuleParams($parameters, 'payment_novalnet_invoice');

			// Form payment parameters.
			$parameters['invoice_type'] = 'INVOICE';
			$parameters['invoice_ref']  = 'BNR-' . $parameters['product'] . '-' . $parameters['order_no'];

			// Form due date.
			$invoice_duedate                    = trim($this->config->get('payment_novalnet_invoice_due_date'));
			if (!empty($invoice_duedate)) {
				$parameters['due_date'] = date('Y-m-d', mktime(0, 0, 0, date('m'), (date('d') + $invoice_duedate), date('Y')));
			}

			// Perform payment call.
			$server_response = $this->model_extension_payment_novalnet->performPaymentCall($parameters);
			// Validate paygate response.
			if($this->model_extension_payment_novalnet->checkResponseStatus($server_response)) {				
				if(!empty($parameters['pin_by_callback']) || !empty($parameters['pin_by_sms'])) {
					$this->session->data['payment_novalnet_invoice'] = $server_response;
					$this->json = $this->model_extension_payment_novalnet->pinbyCallbackResponseProcess($server_response, 'payment_novalnet_invoice');
					$this->response->addHeader('Content-Type: application/json');
					$this->response->setOutput(json_encode($this->json));
					return false;
				}
			}
		} else { 
			$this->json['error'] = $this->model_extension_payment_novalnet->pinValidation();
			if (!empty($this->json['error'])) {
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($this->json));
				return false;
			}
			$server_response = $this->model_extension_payment_novalnet->sendPinConfirmation('payment_novalnet_invoice');
		}
		if(!empty($server_response['status']) && $server_response['status'] == '100') {						
			$server_response['additional_details'] = json_encode(array(
				'due_date'  => isset($server_response['due_date']) ? $server_response['due_date'] : '',
				'invoice_iban'  => $server_response['invoice_iban'],
				'invoice_bic'  => $server_response['invoice_bic'],
				'invoice_bankname'  => $server_response['invoice_bankname'],
				'invoice_bankplace'  => $server_response['invoice_bankplace'],
			));
			$data = $this->model_extension_payment_novalnet->transactionSuccess($server_response, $this->payment_method);
			// Generate Novalnet comments.
			if($server_response['tid_status'] != 75) {
				$data['novalnet_comments'] .= $this->model_extension_payment_novalnet->prepareNovalnetComments($server_response, $data['order_info'], $this->payment_method, $this->session->data['order_id']);
			}
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $data['orderStatus'], $this->db->escape($data['novalnet_comments']), true);
			$this->model_extension_payment_novalnet->unsetSessionValues('payment_novalnet_invoice');
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
			'text_fraud_mobile',
			'text_fraud_tel',
			'text_fraud_transaction_pin',
			'text_fraud_forgot_pin',
			'novalnet_fraud_sms_msg',
			'novalnet_fraud_tel_msg',
			'text_guarantee_payment_dob',
			'text_order_processed'
		) as $value) {
			$data[$value] = $this->language->get($value);
		}
		return $data;
	}
}
