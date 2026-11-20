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
 * Script : novalnet_eps.php
 */

class ControllerExtensionPaymentNovalnetEps extends Controller
{
	private $json = array();

	private $payment_method = 'novalnet_eps';

	/**
	 * Initiate payment process
	 *
	 * @param       none
	 * @return      none
	 */
	public function index()
	{
		// Load language content.
		$this->language->load('extension/payment/novalnet_eps');

		// Load Novalnet model.
		$this->load->model('extension/payment/novalnet');

		// Assign basic details.
		$data = $this->model_extension_payment_novalnet->getBasicDetails('payment_novalnet_eps');

		// Add language content.
		$data = $this->getLanguageContent($data);

		// Add template.
		return $this->load->view('extension/payment/novalnet_eps', $data);
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
		$this->language->load('extension/payment/novalnet_eps');

		// Load model.
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/novalnet');

		// Build Basic parameters.
		$parameters = $this->model_extension_payment_novalnet->getParameters($this->payment_method);

		// Build Third party parameters.
		$parameters = $this->model_extension_payment_novalnet->getRedirectParameters($parameters, 'novalnet_eps');

		// Redirect to Novalnet server.
		$this->json = $this->model_extension_payment_novalnet->performRedirectProcess($this->model_extension_payment_novalnet->getUrl('giropay'), $parameters, $this->payment_method);
		echo json_encode($this->json);
		exit();
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
			'text_title',
			'text_order_processed'
		) as $value) {
			$data[$value] = $this->language->get($value);
		}
		return $data;
	}
}
