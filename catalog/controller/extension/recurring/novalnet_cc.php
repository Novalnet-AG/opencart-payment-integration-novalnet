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
 *
 */
class ControllerExtensionRecurringNovalnetCc extends Controller {

	/**
	 * Initiate payment process
	 *
	 * @param       none
	 * @return      none
	 */
	public function index() {
		if (isset($this->request->get['order_recurring_id'])) {
			$order_recurring_id = $this->request->get['order_recurring_id'];
		} else {
			$order_recurring_id = 0;
		}

		$this->load->model('account/recurring');

		$recurring_info = $this->model_account_recurring->getOrderRecurring($order_recurring_id);

		if ($recurring_info) {
			// Load Novalnet model.
			$this->load->model('extension/payment/novalnet');
			$data['subscription_details'] = $this->model_extension_payment_novalnet->dbSelect('novalnet_subscriptions', 'next_subs_cycle', 'order_recurring_id =' . $this->request->get['order_recurring_id']);
			// Load language.
			$this->load->language('extension/payment/novalnet_common');
			foreach(array('text_novalnet_TID', 'text_novalnet_order_no', 'text_novalnet_amount', 'text_transaction_details', 'text_payment_method', 'text_next_charging_date', 'text_recurring_orders', 'button_subscription_cancel', 'text_loading') as $value){
				$data[$value] = $this->language->get($value);
			}
			//Get order status id from order table
			$data['recurring_details'] = $this->model_extension_payment_novalnet->dbSelect('novalnet_recurring_transactions', 'order_no, tid, amount, payment_type, transaction_details, status', 'order_recurring_id =' . $this->request->get['order_recurring_id'], true);
			// Load language.
			$this->load->language('extension/payment/novalnet_cc');
			$data['payment_method'] = $this->language->get('text_novalnet_cc_title');
			$data['payment_type'] = 'novalnet_cc';
			$data['order_recurring_id'] = $order_recurring_id;
			$data['next_subs_cycle'] = $data['subscription_details']['next_subs_cycle'];
			return $this->load->view('extension/recurring/novalnet_recurring', $data);
		}
	}
}
