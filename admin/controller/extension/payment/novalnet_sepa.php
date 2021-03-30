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
		$data = array();

		// Load language.
		$this->language->load('extension/payment/novalnet_sepa');
		$this->document->setTitle($this->language->get('heading_title'));

		// Load novalnet model.
		$this->load->model('setting/setting');
		$this->load->model('extension/payment/novalnet');

		// Validate and store payment configuration.
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			$this->model_extension_payment_novalnet->storeConfigurations('payment_novalnet_sepa');
		}
		$data['heading_title']    = $this->language->get('heading_title');
		$data = array_merge($data, $this->model_extension_payment_novalnet->getTemplateDetails('novalnet_sepa'));

		// Assign error.

		$data['error_warning']    = $this->error['error_warning'];
		$data['error_warning_id'] = $this->error['error_warning_id'];

		// Get language content.
		$this->getLanguageContent($data);
		foreach (array(
			'payment_novalnet_sepa_status',
			'payment_novalnet_sepa_testmode',
			'payment_novalnet_sepa_fraud_enable',
			'payment_novalnet_sepa_fraud_min_val',
			'payment_novalnet_sepa_buyer_notification',
			'payment_novalnet_sepa_order_completion_status',
			'payment_novalnet_sepa_shopping_type',
			'payment_novalnet_sepa_total',
			'payment_novalnet_sepa_geo_zone_id',
			'payment_novalnet_sepa_sort_order',
			'payment_novalnet_sepa_due_date',
		    'payment_novalnet_sepa_guarantee_payment_enable',
			'payment_novalnet_sepa_guarantee_minimum_order_amount',
			'payment_novalnet_sepa_guarantee_payment_force',
			'payment_novalnet_sepa_manual_limit',
			'payment_novalnet_sepa_authenticate',
			'payment_novalnet_sepa_guarantee_pending_order_status'
		) as $fields) {
			$data[$fields] = (isset($this->request->post[$fields])) ? $this->request->post[$fields] : $this->config->get($fields);
		}		
		
		$this->response->setOutput($this->load->view('extension/payment/novalnet_sepa', $data));
	}

	/**
	 * Get language content from language file.
	 *
	 * @param       $data
	 * @return      none
	 */
	public function getLanguageContent(&$data) {
		foreach (array(
			'enable_test_mode',
			'enable_fraud_module',
			'enable_fraud_module_desc',
			'minimum_val_fraud_module',
			'minimum_val_fraud_module_desc',
			'notification_buyer',
			'notification_buyer_desc',
			'order_completion_status',
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
			'fraud_module_none',
			'fraud_module_callback',
			'fraud_module_sms',
			'text_novalnet_sepa',
			'logo_novalnet_sepa',
			'button_save',
			'button_saveclose',
			'button_cancel',
			'entry_minimum_goods',
			'entry_minimum_goods_desc',
			'entry_sort_order_desc',
			'entry_geo_zone',
			'entry_geo_zone_desc',
			'onhold_payment_action',
			'text_all_zones',
			'entry_sort_order',
			'text_sepa_due_date',
			'text_sepa_due_date_desc',
			'text_guarantee_payment_configuration',
			'text_guarantee_payment_requirements',
			'text_guarantee_payment_requirements_1',
			'text_guarantee_payment_requirements_2',
			'text_guarantee_payment_requirements_3',
			'text_guarantee_payment_requirements_4',
			'text_guarantee_payment_requirements_5',
			'text_guarantee_payment_requirements_6',
			'text_guarantee_payment_enable',
			'text_guarantee_payment_minimum_order_amount',
			'text_guarantee_payment_minimum_order_amount_desc',
			'text_guarantee_payment_force_desc',
			'text_guarantee_payment_force',
			'error_guarantee_payment_minimum',
			'shopping_type_none',
			'authorize',
			'capture'
		) as $value) {
			$data[$value] = $this->language->get($value);
		}
	}

	/**
	 * Validate the sepa duedate and guarantee payment configurations
	 *
	 * @param       none
	 * @return      boolean
	 */
	public function validate() {
		if (!empty($this->request->post['payment_novalnet_sepa_guarantee_payment_enable'])) {

			$minimum_amount = !empty($this->request->post['payment_novalnet_sepa_guarantee_minimum_order_amount']) ? trim($this->request->post['payment_novalnet_sepa_guarantee_minimum_order_amount']) : 999;

			// Validate for minimum amount.
			if (!$this->model_extension_payment_novalnet->isNumeric($minimum_amount)) {
				$this->error['error_warning']    = $this->language->get('text_guarantee_payment_minimum_error');
				$this->error['error_warning_id'] = 'novalnet_sepa_guarantee_minimum_order_amount';
				return false;

			} else if ($minimum_amount < 999) {
				$this->error['error_warning'] = $this->language->get('text_guarantee_payment_minimum_error');
				$this->error['error_warning_id'] = 'novalnet_sepa_guarantee_minimum_order_amount';
				return false;
			}
		}
		$this->load->model('extension/payment/novalnet');
		$sepa_due_date = trim($this->request->post['payment_novalnet_sepa_due_date']);

		if ((!empty($sepa_due_date) && $sepa_due_date < 2 || $sepa_due_date > 14) || $sepa_due_date == '0') {
			$this->error['error_warning'] = $this->language->get('error_duration_date');
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Fetching and displaying Novalnet extension features
	 *
	 * @param       none
	 * @return      string
	 */
	public function order() {

		if ($this->config->get('payment_novalnet_sepa_status')) {
			$this->load->language('extension/payment/novalnet_common');
			$this->load->model('extension/payment/novalnet');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['order_id']      = (!empty($this->request->get['order_id'])) ? $this->request->get['order_id'] : 0;

			// Get order details.
			$data['order_details'] = $this->model_extension_payment_novalnet->getNovalnetOrders($data['order_id']);

			if(!empty($data['order_details']['gateway_status']) && in_array($data['order_details']['gateway_status'], array('99', '100'))) {

				$data['transaction_details'] =$data['order_details']['transaction_details'];
				$data['user_token']         = $this->session->data['user_token'];

				// Show zero amount booking.
				$data = $this->model_extension_payment_novalnet->showAmountBookTab($data);

				if(!$data['show_amount_book']) {

					// Show Manage transaction.
					$data = $this->model_extension_payment_novalnet->showManageTransactionTab($data);

					// Show refund.
					$data = $this->model_extension_payment_novalnet->showRefundTab($data);

					// Show amount update.
					if($data['order_details']['payment_id'] != "40")
						$data = $this->model_extension_payment_novalnet->showAmountUpdateTab($data);

					// Load Template.
				}
				return $this->load->view('extension/payment/novalnet_order', $data);
			}
		}
	}

	/**
	 * Fetching and displaying Novalnet recurring details
	 *
	 * @param       none
	 * @return      string
	 */
	public function recurringButtons() {
		// Load Novalnet Model.
		$this->load->model('extension/payment/novalnet');

		// Load language.
		$this->load->language('extension/payment/novalnet_common');
		foreach(array('text_novalnet_TID', 'text_novalnet_order_no', 'text_novalnet_amount', 'text_transaction_details', 'text_payment_method', 'text_next_charging_date', 'text_recurring_orders', 'button_subscription_cancel', 'text_loading') as $value){
			$data[$value] = $this->language->get($value);
		}

		$data['subscription_details'] = $this->model_extension_payment_novalnet->dbSelect('novalnet_subscriptions', 'next_subs_cycle', 'order_recurring_id =' . $this->request->get['order_recurring_id']);

		//Get order status id from order table
		$data['recurring_details'] = $this->model_extension_payment_novalnet->dbSelect('novalnet_recurring_transactions', 'order_no, tid, amount, payment_type, transaction_details, status', 'order_recurring_id =' . $this->request->get['order_recurring_id'], true);

		// Load language.
		$this->load->language('extension/payment/novalnet_sepa');
		$data['payment_method'] = $this->language->get('heading_title');
		$data['next_subs_cycle'] = (!empty($data['subscription_details']['next_subs_cycle'])) ? $data['subscription_details']['next_subs_cycle'] : '';
		$data['order_recurring_id'] = $this->request->get['order_recurring_id'];
		$data['user_token']               = $this->session->data['user_token'];
		return $this->load->view('sale/novalnet_recurring', $data);
	}
}
