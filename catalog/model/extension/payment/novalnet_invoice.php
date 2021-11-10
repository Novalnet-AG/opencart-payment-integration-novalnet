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
 *
 */

class ModelExtensionPaymentNovalnetInvoice extends Model
{
	private $payment_method = 'novalnet_invoice';
	
	/**
	 * To display the payment in front end.
	 *
	 * @param       $address
	 * @param       $total
	 * @return      array
	 */
	public function getMethod($address, $total) {
		$this->load->model('extension/payment/novalnet');
		$status = $this->model_extension_payment_novalnet->getOptionMethod($address, $total, $this->payment_method);
		$max_time_status = false;
		if ($status) {
			if (!empty($this->session->data['payment_novalnet_invoice_max_time']) && $this->session->data[$this->payment_method . '_max_time'] > time()) {
				$max_time_status = true;
			} else {
				unset($this->session->data['payment_novalnet_invoice_max_time']);
			}

			if (!$max_time_status) {
				return $this->model_extension_payment_novalnet->showPaymentMethod($this->payment_method, $address, $total);
			}
		}
		return array();
	}

	/**
	 * Supports recurring payments.
	 *
	 * @return      boolean
	 */
	public function recurringPayments()
	{
		return true;
	}
}
