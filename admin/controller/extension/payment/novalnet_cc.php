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
		$this->language->load('extension/payment/novalnet_cc');
		$this->document->setTitle($this->language->get('novalnet_heading_title'));

		// Load Novalnet model.
		$this->load->model('extension/payment/novalnet');

		// Validate and store payment configuration.
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_extension_payment_novalnet->storeConfigurations('payment_novalnet_cc');
			
		}
		
        
        // Get template details.
		$data = $this->model_extension_payment_novalnet->getTemplateDetails('novalnet_cc');

		// Assign error.
		$data['error_warning']    = $this->error['error_warning'];
		$data['error_warning_id'] = $this->error['error_warning_id'];

		// Add language content.
		$this->getLanguageContent($data);

		// Add configuaration content.
		$this->getConfigurationContent($data);		
		
		
		// Add template.
		
		$this->response->setOutput($this->load->view('extension/payment/novalnet_cc', $data));
	
}
	

	/**
	 * Get configuration content.
	 *
	 * @param       $data
	 * @return      none
	 */
	public function getConfigurationContent(&$data) {
		foreach (array(
			'payment_novalnet_cc_status',
			'payment_novalnet_cc_testmode',
			'payment_novalnet_cc_3d_enable',
			'payment_novalnet_cc_buyer_notification',
			'payment_novalnet_cc_order_completion_status',
			'payment_novalnet_cc_shopping_type',
			'payment_novalnet_cc_total',
			'payment_novalnet_cc_geo_zone_id',
			'payment_novalnet_cc_sort_order',
			'payment_novalnet_cc_image',
			'payment_novalnet_cc_iframe_standard_css_text',
			'payment_novalnet_cc_iframe_standard_input',
			'payment_novalnet_cc_iframe_standard_label',
			'payment_novalnet_cc_manual_limit',
			'payment_novalnet_cc_authenticate',
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
			'entry_enable_3d',
			'entry_enable_3d_desc',
			'entry_display_amex_logo',
			'entry_display_amex_logo_desc',
			'entry_display_maestro_logo',
			'entry_display_maestro_logo_desc',
			'onhold_payment_action',
			'onhold_payment_action_desc',
			'shopping_type',
			'shopping_type_desc',
			'shopping_type_none',
			'one_click_shopping',
			'zero_amount_booking',
			'text_novalnet_cc',
			'logo_novalnet_cc',
			'entry_minimum_goods',
			'entry_minimum_goods_desc',
			'entry_sort_order_desc',
			'entry_geo_zone',
			'entry_geo_zone_desc',
			'text_all_zones',
			'entry_sort_order',
			'notification_buyer',
			'order_completion_status',
			'order_completion_status_desc',
			'notification_buyer_desc',
			'text_true',
			'text_false',
			'entry_status',
			'entry_enable_payment',
			'text_enabled',
			'text_disabled',
			'enable_test_mode',
			'form_mode_desc',
			'text_iframe_configuration',
			'text_iframe_form_appearance',
			'text_iframe_css_text',
			'text_iframe_input',
			'authorize',
			'capture'

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
		
		if ($this->config->get('payment_novalnet_cc_status')) { 
			$this->load->language('extension/payment/novalnet_common');
			$this->load->model('extension/payment/novalnet');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['order_id']      = (!empty($this->request->get['order_id'])) ? $this->request->get['order_id'] : 0;

			// Get order details.
			$data['order_details'] = $this->model_extension_payment_novalnet->getNovalnetOrders($data['order_id']);

			if(in_array($data['order_details']['gateway_status'], array('98', '100'))) {

				$data['transaction_details'] = $data['order_details']['transaction_details'];
				$data['user_token']               = $this->session->data['user_token'];

				// Show zero amount booking.
				$data = $this->model_extension_payment_novalnet->showAmountBookTab($data);

				if(!$data['show_amount_book']) {

					// Show Manage transaction.
					$data = $this->model_extension_payment_novalnet->showManageTransactionTab($data);

					// Show refund.
					$data = $this->model_extension_payment_novalnet->showRefundTab($data);
				}

				// Load Template.
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
		$this->load->language('extension/payment/novalnet_cc');
		$data['payment_method'] = $this->language->get('heading_title');
		$data['next_subs_cycle'] = $data['subscription_details']['next_subs_cycle'];
		$data['order_recurring_id'] = $this->request->get['order_recurring_id'];
		$data['user_token']               = $this->session->data['user_token'];		
		return $this->load->view('sale/novalnet_recurring', $data);
	}
	
	
	
}
