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
 * Script : novalnet_recurring.php
 *
 */
class ControllerExtensionRecurringNovalnetRecurring extends Controller {
	
	/**
	 * Initiate payment process
	 *
	 * @param       none
	 * @return      none
	 */
    public function index() {
        $this->load->language('extension/payment/novalnet_invoice');

        if (isset($this->request->get['order_recurring_id'])) {
            $order_recurring_id = $this->request->get['order_recurring_id'];
        } else {
            $order_recurring_id = 0;
        }

        $this->load->model('account/recurring');

        $recurring_info = $this->model_account_recurring->getOrderRecurring($order_recurring_id);

        if ($recurring_info) {
            $data['text_loading'] = $this->language->get('text_loading');

            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_cancel'] = $this->language->get('button_cancel');

            $data['continue'] = $this->url->link('account/recurring', '', true);

            if ($recurring_info['status'] == 2 || $recurring_info['status'] == 3) {
                $data['order_recurring_id'] = $order_recurring_id;
            } else {
                $data['order_recurring_id'] = '';
            }

            return $this->load->view('extension/recurring/novalnet_invoice', $data);
        }
    }

    public function recurringCancel() {
        $json = array();
        $this->load->language('extension/payment/novalnet_common');
        //Load Novalnet model.
        $this->load->model('extension/payment/novalnet');

        $this->model_extension_payment_novalnet->dbUpdate('novalnet_subscriptions', array(
            'next_subs_cycle' => "'0000-00-00'"
        ), 'order_recurring_id=' . $this->request->request['order_recurring_id']);

        $this->model_extension_payment_novalnet->dbUpdate('order_recurring', array(
            'status' => "'3'"
        ), 'order_recurring_id=' . $this->request->request['order_recurring_id']);

        $json['success'] = $this->language->get('text_recurring_cancel');

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * Execution of Novalnet cron process
     *
     * @param      none
     * @return      array
     */
    public function cronProcess() {
        $this->load->model('extension/payment/novalnet');
        $this->load->language('extension/payment/novalnet_common');
        $this->load->model('account/order');
        $this->load->model('account/recurring');
        $this->load->model('checkout/order');
        $recurring_profiles      = $this->model_extension_payment_novalnet->getNovalnetRecurringProfiles();
        $novalnet_response      = array();
        $next_payment_error_msg = $this->language->get('text_recurring_date_not_met');
        if (!empty($recurring_profiles)) {
            foreach ($recurring_profiles as $profile) {

                $recurring_order                = $this->model_extension_payment_novalnet->getRecurringOrder($profile['order_recurring_id']);
                $recurring_info = $this->model_extension_payment_novalnet->getRecuringOrders($profile['order_recurring_id']);
                $recurring_order['trial_details'] = json_decode($recurring_order['trial_details'], true);
                $next_payment                   = new DateTime($recurring_order['next_subs_cycle']);
                $today                          = new DateTime('now');

                $recurring_order['recurring_details'] = json_decode($recurring_order['recurring_details'], true);
                $proceed_payment = false;
                if(!empty($recurring_order['trial_details']['trial_duration']) && $recurring_order['trial_details']['trial_duration'] > $recurring_info->num_rows) {
                    $proceed_payment = true;
                    $amount = $recurring_order['trial_details']['trial_price'];
                    $next_payment = $this->model_extension_payment_novalnet->calculateSubscriptionSchedule($recurring_order['trial_details']['trial_frequency'], $next_payment, $recurring_order['trial_details']['trial_cycle']);

                } else if(isset($recurring_order['recurring_details']['recurring_duration'])) {
                    $total_length = !empty($recurring_order['trial_details']['trial_duration']) ? (int)$recurring_order['trial_details']['trial_duration'] + (int)$recurring_order['recurring_details']['recurring_duration'] : $recurring_order['recurring_details']['recurring_duration'];
                    if($total_length > $recurring_info->num_rows || ($recurring_order['recurring_details']['recurring_duration'] == 0 && $total_length <= $recurring_info->num_rows)) {
                        $proceed_payment = true;
                        $amount = $recurring_order['recurring_details']['recurring_price'];
                        $next_payment = $this->model_extension_payment_novalnet->calculateSubscriptionSchedule($recurring_order['recurring_details']['recurring_frequency'], $next_payment, $recurring_order['recurring_details']['recurring_cycle']);
                    }
                } else{
                    continue;
                }
                $order_info = $this->model_checkout_order->getOrder($profile['order_id']);

                // Check and process payment
                if($proceed_payment) {
                    $data = $this->model_extension_payment_novalnet->getParameters($order_info['payment_code'], $order_info);
                    $reference_details = $this->model_extension_payment_novalnet->getReferenceDetails($profile['order_id']);
                    $reference_details = json_decode($reference_details['transaction_details'], true);

                    $data['amount'] = round($amount * $order_info['currency_value']);
                    unset($data['order_no']);
                    if(in_array($order_info['payment_code'], array('novalnet_invoice', 'novalnet_prepayment'))) {
                        $data['invoice_type'] = $data['payment_type'];
                        if($order_info['payment_code'] == 'novalnet_invoice'){
                            $invoice_duedate = trim($this->config->get('novalnet_invoice_due_date'));
                            if (!empty($invoice_duedate)) {
                                $data['due_date'] = date('Y-m-d', mktime(0, 0, 0, date('m'), (date('d') + $invoice_duedate), date('Y')));
                            }
                        }
                    } else {
                        $data['payment_ref'] = (!empty($reference_details['reference_tid']) && $reference_details['reference_tid'] != 'NULL') ? $reference_details['reference_tid'] : $recurring_order['tid'];
                    }

                    $this->log->write($this->language->get('text_recurring_request_parameters') . ' -> ' . json_encode($data));
                    $server_response = $this->model_extension_payment_novalnet->performPaymentCall($data);
                    if (!empty($server_response['status'])  && in_array($server_response['status'], array('100', '90'))) {
                        $novalnet_response[$profile['order_recurring_id']] = $server_response;
                        $this->log->write($this->language->get('text_recurring_response_parameters') . ' -> ' . json_encode($novalnet_response[$profile['order_recurring_id']]));
                        $update_subscription_details = array(
                            'next_subs_cycle' => "'" . date_format($next_payment, 'Y-m-d') . "'",
                            'recurring_date_added' => "'" . date_format($today, 'Y-m-d') . "'",
                        );
                        $this->model_extension_payment_novalnet->dbUpdate('novalnet_subscriptions', $update_subscription_details, 'order_recurring_id=' . $profile['order_recurring_id']);
                        $this->load->language('extension/payment/' . $order_info['payment_code']);

                        // Prepare transaction comments.
                        $transaction_comments = $this->model_extension_payment_novalnet->prepareTransactionComments($server_response, $order_info['payment_code']);
                        $formated_amount = $this->currency->format(($data['amount']/100), $order_info['currency_code'], '1');

                        // Get callback amount.
                        $callback_amount = (in_array($order_info['payment_code'], array('novalnet_invoice', 'novalnet_prepayment')) || ($order_info['payment_code'] == 'novalnet_paypal' && $server_response['tid_status'] == '90')) ? 0 : $amount;

                        $paid_status = 'paid';
                        if(in_array($data['key'], array('27', '41'))) {
                            $order_info['total'] = ($amount/100);
                            $order_info['currency'] = $data['currency'];
                            $transaction_comments .= $this->model_extension_payment_novalnet->prepareBankDetailsComments($server_response, $order_info);
                            $paid_status = 'unpaid';
                        } else if ($server_response['status'] == '90') {
                            $paid_status = 'unpaid';
                        }

                        $this->db->query("INSERT INTO " . DB_PREFIX . "order_recurring_transaction SET order_recurring_id = '" . (int)$recurring_order['order_recurring_id'] . "', reference='" . $server_response['tid'] . "', date_added = NOW(), amount = '" . (float) ($amount/100) . "', type = '1'");

                        $this->db->query("INSERT INTO " . DB_PREFIX . "novalnet_recurring_transactions SET order_no = '" . $recurring_order['order_no'] . "', order_recurring_id=" . $recurring_order['order_recurring_id'] . ", tid='" . $server_response['tid'] . "', amount = '" . $formated_amount . "', payment_type='" . $order_info['payment_code'] . "', transaction_details='" . $transaction_comments . "', status='" . $paid_status . "', date_added = NOW()");

                        $this->db->query("INSERT INTO " . DB_PREFIX . "novalnet_merchant_script SET order_no = '" . $recurring_order['order_no'] . "',  original_tid=" . $server_response['tid'] . ", callback_tid='" . $server_response['tid'] . "', payment_type='" . $order_info['payment_code'] . "', amount = '" . $callback_amount . "', date = '" . date('Y-m-d H:i:s') . "'");
                        $additional_details = '';
                        if(in_array($order_info['payment_code'], array('novalnet_invoice', 'novalnet_prepayment'))) {
                            $additional_details =  addslashes(json_encode(array(
                                'due_date'      => $server_response['due_date'],
                                'invoice_iban'      => $server_response['invoice_iban'],
                                'invoice_bic'       => $server_response['invoice_bic'],
                                'invoice_bankname'      => $server_response['invoice_bankname'],
                                'invoice_bankplace'     => $server_response['invoice_bankplace'],
                            )));
                        }

                        $this->db->query("INSERT INTO " . DB_PREFIX . "novalnet_transactions SET order_no = '" . $recurring_order['order_no'] . "',  tid=" . $server_response['tid'] . ", gateway_status='" . $server_response['tid_status'] . "', payment_type='" . $order_info['payment_code'] . "', payment_id=" . $data['key'] . ", customer_id = " . $order_info['customer_id'] . ", create_payment_ref = '', payment_configurations = '" . json_encode(array(
                                'vendor' => $data['vendor'],
                                'product' => $data['product'],
                                'tariff' => $data['tariff'],
                                'auth_code' => $data['auth_code'],
                                'test_mode' => $data['test_mode'],
                            )) . "', transaction_details = '" . json_encode(array(
                                'amount'        => $data['amount'],
                                'total_amount'  => $data['amount'],
                                'refund_amount' => 0,
                                'currency'      => $order_info['currency_code'],
                                'reference_tid' => !empty($data['payment_ref']) ? $data['payment_ref'] : '',
                            )) . "', additional_details='" . $additional_details . "', date = '" . date('Y-m-d H:i:s') . "'");
                    } else {
                        $novalnet_response[$profile['order_recurring_id']] = (!empty($server_response['status_desc'])) ? $server_response['status_desc'] : (!empty($server_response['status_text']) ? $server_response['status_text'] : $this->language->get('error_payment_not_successful'));
                        $this->log->write($novalnet_response[$profile['order_recurring_id']]);
                    }
                } else {
                    $novalnet_response[$profile['order_recurring_id']] = $this->language->get('text_recurring_profile_canceled');
                    $this->log->write($novalnet_response[$profile['order_recurring_id']]);
                    $this->model_extension_payment_novalnet->dbUpdate('novalnet_subscriptions', array(
                        'next_subs_cycle' => "'0000-00-00'"
                    ), 'order_recurring_id=' . $profile['order_recurring_id']);
                    $this->model_extension_payment_novalnet->dbUpdate('order_recurring', array(
                        'status' => "'5'"
                    ), 'order_id=' . $order_info['order_id']);
                }
            }
        }
        echo "Cron response<pre>";
        $this->log->write(json_encode(((!empty($novalnet_response)) ? $novalnet_response : $next_payment_error_msg)));
        print_r((!empty($novalnet_response)) ? $novalnet_response : $next_payment_error_msg);
    }
}
