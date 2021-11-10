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
 * @license   https://www.novalnet.de/payment-plugins/kostenlos/lizenz.
 *
 * Script : novalnet_przelewy24.php
 */

class ControllerExtensionPaymentNovalnetPrzelewy24 extends Controller
{
	private $error = array(
		'error_warning'    => '',
		'error_warning_id' => '',
	);

	/**
	 * Initiate the payment configurations
	 *
	 * @param       none
	 * @return      none
	 */
	public function index() {

		// Load language.
		$this->language->load('extension/payment/novalnet_przelewy24');
		$this->document->setTitle($this->language->get('novalnet_heading_title'));

		// Load novalnet model.
		$this->load->model('extension/payment/novalnet');

		// Validate and store payment configuration.
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_extension_payment_novalnet->storeConfigurations('payment_novalnet_przelewy24');
		}

		// Get template details.
		$data = $this->model_extension_payment_novalnet->getTemplateDetails('novalnet_przelewy24');

		// Assign error.
		$data['error_warning']    = $this->error['error_warning'];
		$data['error_warning_id'] = $this->error['error_warning_id'];

		// Add language content.
		$this->getLanguageContent($data);

		// Add configuration content.
		$this->getConfigurationContent($data);

		// Add template.
		$this->response->setOutput($this->load->view('extension/payment/novalnet_przelewy24', $data));
	}

	/**
	 * Get configuration content.
	 *
	 * @param       $data
	 * @return      none
	 */
	public function getConfigurationContent(&$data) {
		foreach (array(
			'payment_novalnet_przelewy24_status',
			'payment_novalnet_przelewy24_testmode',
			'payment_novalnet_przelewy24_buyer_notification',
			'payment_novalnet_przelewy24_pending_order_status',
			'payment_novalnet_przelewy24_order_completion_status',
			'payment_novalnet_przelewy24_shopping_type',
			'payment_novalnet_przelewy24_total',
			'payment_novalnet_przelewy24_geo_zone_id',
			'payment_novalnet_przelewy24_sort_order',
		) as $field) {
			$data[$field] = (isset($this->request->post[$field])) ? $this->request->post[$field] : $this->config->get($field);
		}
	}

	/**
	 * Get language content from language file.
	 *
	 * @param       $data
	 * @return      none
	 */
	public function getLanguageContent(&$data) {
		foreach (array(
			'novalnet_heading_title',
			'enable_test_mode',
			'notification_buyer',
			'notification_buyer_desc',
			'order_completion_status',
			'przelewy24_pending_status',
			'text_true',
			'text_false',
			'entry_status',
			'entry_enable_payment',
			'text_enabled',
			'text_disabled',
			'shopping_type',
			'shopping_type_desc',
			'one_click_shopping',
			'zero_amount_booking',
			'text_novalnet_przelewy24',
			'logo_novalnet_przelewy24',
			'entry_minimum_goods',
			'entry_minimum_goods_desc',
			'entry_sort_order_desc',
			'entry_geo_zone',
			'entry_geo_zone_desc',
			'text_all_zones',
			'entry_sort_order',
			'shopping_type_none'
		) as $value) {
			$data[$value] = $this->language->get($value);
		}
	}

	/**
	 * Fetching and displaying Novalnet extension features
	 *
	 * @param       none
	 * @return      string
	 */
	public function order() {
		if ($this->config->get('payment_novalnet_przelewy24_status')) {
			$this->load->language('extension/payment/novalnet_common');
			$this->load->model('extension/payment/novalnet');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['order_id']      = (!empty($this->request->get['order_id'])) ? $this->request->get['order_id'] : 0;

			// Get order details.
			$data['order_details'] = $this->model_extension_payment_novalnet->getNovalnetOrders($data['order_id']);

			if($data['order_details']['gateway_status'] == '100') {

				$data['transaction_details'] =$data['order_details']['transaction_details'];
				$data['user_token']         = $this->session->data['user_token'];

				// Show refund.
				$data = $this->model_extension_payment_novalnet->showRefundTab($data);

				// Load Template.
				return $this->load->view('extension/payment/novalnet_order', $data);
			}
		}
	}
}
