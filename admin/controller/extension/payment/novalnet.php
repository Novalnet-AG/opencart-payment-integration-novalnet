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
 * Script : novalnet.php
 */
class ControllerExtensionPaymentNovalnet extends Controller
{
    private $error = array(
        'error_warning'    => '',
        'error_warning_id' => '',
    );

    private $json = array();

    public function index() {

        // Load language.
        $this->load->language('extension/payment/novalnet');

        $this->document->setTitle($this->language->get('novalnet_heading_title'));

        // Load novalnet model.
        $this->load->model('extension/payment/novalnet');

        // Store payment configuration.
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_extension_payment_novalnet->storeConfigurations('payment_novalnet');
        }

        // Get template details.
        $data = $this->model_extension_payment_novalnet->getTemplateDetails('novalnet');

        // Assign title.
        $data['novalnet_heading_title'] = $this->language->get('novalnet_heading_title');

        // Assign default values.
        $data['server_ip']     = $this->getIpAddress('SERVER_ADDR');
        $data['remote_ip']     = $this->getIpAddress('REMOTE_ADDR');       
        $data['default_callback_url']   = (($this->request->server['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=callback/vendorScript';
        $data['cron_job_url']   = (($this->request->server['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=extension/recurring/novalnet_recurring/cronProcess';
        // Assign error.
        $data['error_warning']    = $this->error['error_warning'];
        $data['error_warning_id'] = $this->error['error_warning_id'];

        // Add language content.
        $this->getLanguageContent($data);

        // Add configuration content.
        $this->getConfigurationContent($data);

        $this->model_extension_payment_novalnet->install();

        // Add template.
        $this->response->setOutput($this->load->view('extension/payment/novalnet', $data));
    }

    public function install() {
        $this->load->model('extension/payment/novalnet');
        $this->load->model('setting/event');
        $this->model_setting_event->addEvent('novalnet_login', 'catalog/controller/account/logout/after', 'extension/module/novalnet/logout');
    }

    public function uninstall() {
        $this->load->model('setting/event');
        $this->model_setting_event->deleteEvent('novalnet_login');
    }


    /**
     * Get language content from language file.
     *
     * @param       $data
     * @return      none
     */
    public function getLanguageContent(&$data) {
        foreach (array(
            'entry_merchant_id',
            'entry_authcode',
            'entry_project_id',
            'entry_tariff',
            'entry_tariff_desc',
            'heading_title',
            'entry_payment_access_key',
            'entry_onhold_limit',
            'entry_referrer_id',
            'entry_payment_logo',
            'entry_proxy_server',
            'entry_gateway_timeout',
            'entry_onhold_management',
            'entry_onhold_confirm_status',
            'entry_onhold_cancel_status',
            'entry_merchant_script_management',
            'entry_merchant_script_test_mode',
            'entry_merchant_script_test_mode_desc',
            'entry_merchant_script_mail_notification',
            'entry_merchant_script_mail_notification_desc',
            'entry_notification_url',
            'entry_email_to_addr',
            'entry_email_bcc_addr',
            'novalnet_payment_logo',
            'text_true',
            'text_false',
            'entry_status',
            'entry_enable_payment',
            'text_enabled',
            'text_disabled',
            'entry_product_activation_key',
            'entry_client_key',
            'entry_subscription_tariff_id',
            'entry_enable_subscription',
            'entry_product_activation_key_desc',
            'error_mandatory_fields',
            'text_novalnet',
            'entry_admin_portal_src',
            'entry_paypal_admin_portal_src',
            'entry_product_activation_key_desc',
            'entry_vendor_desc',
            'entry_authcode_desc',
            'entry_product_desc',
            'entry_payment_access_key_desc',
            'entry_onhold_limit_desc',
            'entry_referrer_id_desc',
            'entry_proxy_server_desc',
            'entry_gateway_timeout_desc',
            'entry_payment_logo_desc',
            'entry_subs_tariff_desc',
            'entry_subs_amount_desc',
            'entry_subs_period_desc',
            'entry_email_to_addr_desc',
            'entry_email_bcc_addr_desc',
            'entry_notification_url_desc',
            'entry_cron_job_url',
            'entry_cron_job_url_desc',
        ) as $value) {
            $data[$value] = $this->language->get($value);
        }
    }

    /**
     * Get configuration content.
     *
     * @param       $data
     * @return      none
     */
    public function getConfigurationContent(&$data) {
        foreach (array(
            'payment_novalnet_merchant_id',
            'payment_novalnet_authcode',
            'payment_novalnet_project_id',
            'payment_novalnet_tariff_id',
            'payment_novalnet_access_key',
            'payment_novalnet_manual_limit',
            'payment_novalnet_onhold_complete_status',
            'payment_novalnet_cancel_status',
            'payment_novalnet_callback_testmode',
            'payment_novalnet_callback_to_addr',
            'payment_novalnet_callback_mail',
            'payment_novalnet_notification_url',
            'payment_novalnet_payment_logo',
            'payment_novalnet_public_key',
            'payment_novalnet_client_key',
            'payment_novalnet_cron_job_url',
            'payment_novalnet_email_notification'
        ) as $field) {
            $data[$field] = (isset($this->request->post[$field])) ? $this->request->post[$field] : $this->config->get($field);
        }

    }

    protected function validate() {
        if (!function_exists('crc32') || !function_exists('bin2hex') || !function_exists('base64_encode') || !function_exists('base64_decode') || !function_exists('pack')) {
            $this->error['error_warning'] = $this->language->get('package_error');
            return false;
        } else if (empty($this->request->post['payment_novalnet_public_key'])) {
            $this->error['error_warning'] = $this->language->get('error_mandatory_fields');
            $this->error['error_warning_id'] = 'payment_novalnet_public_key';
            return false;
        } else if (empty($this->request->post['payment_novalnet_client_key'])) {
            $this->error['error_warning'] = $this->language->get('error_mandatory_fields');
            $this->error['error_warning_id'] = 'payment_novalnet_client_key';
            return false;
        } else if (empty($this->request->post['payment_novalnet_tariff_id'])) {
            $this->error['error_warning'] = $this->language->get('error_mandatory_fields');
            $this->error['error_warning_id'] = 'novalnet_tariff_id';
            return false;
        }
        return true;
    }

    /**
     * For send the request parameters to the server and manage the Novalnet orders(capture / cancel)
     *
     * @param       $order_details
     * @return      array
     */
    public function novalnetApiProcess($order_details) {
        $this->load->model('extension/payment/novalnet');
        $api_params     = array(
            'vendor'    => $order_details['payment_configurations']['vendor'],
            'auth_code' => $order_details['payment_configurations']['auth_code'],
            'product'   => $order_details['payment_configurations']['product'],
            'tariff'    => $order_details['payment_configurations']['tariff'],
            'key'       => $order_details['payment_id'],
            'tid'       => $order_details['tid'],
            'status'    => '100',
            'remote_ip' => $this->getIpAddress('REMOTE_ADDR'),
        );

        switch ($this->request->post['novalnet_action']) {
            case 'capture_void_process':
                $api_params['edit_status'] = '1';

                // Add requested status.
                $api_params['status'] = $this->request->post['transaction_status'];
                break;
            case 'refund_process':
                $api_params['refund_request'] = '1';

                // Add refund amount in request.
                $api_params['refund_param']   = trim($this->request->post['transaction_refund_amount']);

                // Add refund reference.
                if(!empty($this->request->post['refund_ref'])) {
                    $api_params['refund_ref'] = trim($this->request->post['refund_ref']);
                }
                break;
            case 'amount_booking_process':
                unset($order_details['zero_amount_details']['create_payment_ref']);
                $api_params = $order_details['zero_amount_details'];

                // Add booking amount in request.
                $api_params['amount'] = trim($this->request->post['booking_amount']);
                $api_params['payment_ref'] = $order_details['tid'];
                $api_params['order_no'] = $this->request->post['order_no'];
                break;
            case 'amount_update_process':
                $api_params['edit_status'] = '1';
                $api_params['update_inv_amount'] = '1';

                // Add updated amount in request.
                $api_params['amount']            = trim($this->request->post['novalnetAmountUpdate']);

                // Check for due date update.
                if ($order_details['payment_id'] == '27' ) {
                    $api_params['due_date'] = trim($this->request->post['dueDateUpdate']);
                }
                elseif ($order_details['payment_id'] == '59' ) {
                    $api_params['due_date'] = trim($this->request->post['expiryDateUpdate']);
                }
                break;
        }

        $response         = $this->performCurlProcess('https://payport.novalnet.de/paygate.jsp', $api_params);

        parse_str($response, $api_response);
        return $api_response;
    }

    /**
     * Perform CURL process
     *
     * @param       $url
     * @param       $form
     * @return      string
     */
    public function performCurlProcess($url, $form) {
        $ch     = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $form);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Get order status
     *
     * @param      none
     * @return      integer
     */
    public function getOrderStatus() {
        $result = $this->model_extension_payment_novalnet->dbSelect('order', 'order_status_id', 'order_id =' . $this->request->post['order_no']);
        return $result['order_status_id'];
    }

    /**
     * Confirm or Cancel process for the particular transactions.
     *
     * @param       none
     * @return      boolean
     */
    public function captureVoid() {
        $this->load->language('extension/payment/novalnet_common');
        $this->load->model('extension/payment/novalnet');

        // Validate status.
        if (empty($this->request->post['transaction_status'])) {
            $this->json['novalnet_field_error'] = $this->language->get('select_errors');
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($this->json));
        } else {

            $order_details = $this->model_extension_payment_novalnet->getNovalnetOrders($this->request->request['order_id']);
     
            // Perform Novalnet API process.
            $response      = $this->novalnetApiProcess($order_details);
            // Check for valid response.
            if ($this->checkResponseStatus($response)) {
                $status = '';				
				// Check for capture process.
				if(isset($order_details['payment_id']) && in_array($order_details['payment_id'], array('27', '41'))) {

                    if($response['tid_status'] == 100) {
    					$this->json['success'] = $order_details['novalnet_comments'] = sprintf($this->language->get('text_invoice_transaction_confirm'), $order_details['tid'], ($response['due_date']));
    					
    					
    					$status   = ($order_details['payment_id'] == '41') ? $this->config->get('payment_' . $order_details['payment_type'] . '_callback_order_status') : $this->config->get('payment_' . $order_details['payment_type'] . '_order_completion_status');
									
						$qry = $this->db->query('SELECT additional_details FROM ' . DB_PREFIX . 'novalnet_transactions WHERE tid = '.$order_details['tid']);
						$bank_details = (array)json_decode($qry->row['additional_details']);
						$bank_details['tid'] = $order_details['tid'];
						$bank_details['invoice_account_holder'] = 'Novalnet AG';				
						$invoice_details = array(
							'amount'    => $order_details['transaction_details']['amount'] / 100,
							'currency'  => $order_details['transaction_details']['currency'],
						);
						$novalnet_invoice_comments = $this->prepareNovalnetComments($bank_details, $invoice_details, $order_details['payment_type'], $this->request->request['order_id']);
						$this->sendPaymentNotificationMail($this->request->request['order_id'], $novalnet_invoice_comments);
						//Insert details into order_history table
						$this->model_extension_payment_novalnet->updateTransactionComments($novalnet_invoice_comments, $this->request->post['transaction_status'], $status);	
					}                 
					
				} elseif ($this->checkResponseStatus($response, 'tid_status')) {
                    $this->json['success'] = $order_details['novalnet_comments'] = sprintf($this->language->get('text_transaction_confirm'), date('Y-m-d'), date('H:i:s'));
                    $status   = $this->config->get('payment_' . $order_details['payment_type'] . '_order_completion_status');
                }

                // Check for void process.
                if ($this->checkResponseStatus($response, 'tid_status', '103')) {
                    $status = $this->config->get('payment_novalnet_cancel_status');
                    $this->json['success'] = $order_details['novalnet_comments'] = sprintf($this->language->get('text_transaction_cancel'), date('Y-m-d'), date('H:i:s'));
                }

                // Check for PayPal transaction ID
                if(!empty($response['paypal_transaction_id'])) {

                    $this->model_extension_payment_novalnet->dbUpdate('novalnet_transactions', array(
                        'additional_details' => "'" . addslashes(json_encode(array(
                            'paypal_transaction_id' => $response['paypal_transaction_id'],
                            'tid'                   => $order_details['tid'],
                        ))) . "'"
                    ), 'tid=' . $order_details['tid']);
                }

                // Update order details in tables.
                $this->model_extension_payment_novalnet->orderDetailsUpdate($order_details, $this->request->post['transaction_status'], $status);
            } else {
                $this->json['error'] = $order_details['novalnet_comments'] = $this->getResponseText($response);
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($this->json));
        }
    }

    /**
     * Get server response text
     *
     * @param       $response
     * @return      string
     */
    public function getResponseText($response)
    {
        return ((!empty($response['status_desc'])) ? $response['status_desc'] : ((!empty($response['status_message'])) ? ($response['status_message']) : ((!empty($response['status_text'])) ? $response['status_text'] : $this->language->get('error_payment_not_successful'))));
    }

    /**
     * Refund process for the particular transaction
     *
     * @param       none
     * @return      boolean
     */
    public function amountRefund() {

        // Load language content.
        $this->load->language('extension/payment/novalnet_common');

        // Load Novalnet model.
        $this->load->model('extension/payment/novalnet');

        // Get refund amount.
        $transaction_refund_amount = trim($this->request->post['transaction_refund_amount']);

        // Validate refund amount.
        if (!$this->validateAmount($transaction_refund_amount)) {
            $this->json['error'] = $this->language->get('error_amount_invalid');

        } else {

            // Get order details.
            $order_details = $this->model_extension_payment_novalnet->getNovalnetOrders($this->request->request['order_id']);

            // Perform Novalnet API process.
            $response = $this->novalnetApiProcess($order_details);

            // Check for valid response.
            if ($this->checkResponseStatus($response)) {

                // Form notification message.
                $order_details['novalnet_comments']                 = $this->language->get('refund_parent_tid_msg1') . $order_details['tid'] . sprintf($this->language->get('refund_parent_tid_msg2'), ($this->currency->format($transaction_refund_amount / 100, $order_details['transaction_details']['currency'], '1')));

                // Calculate total refunded amount.
                $order_details['transaction_details']['refund_amount'] = ($order_details['transaction_details']['refund_amount'] + $transaction_refund_amount);

                // Get Order status.
                $order_status                   = ($response['tid_status'] != '100') ? $this->config->get('payment_novalnet_cancel_status') : $this->getOrderStatus();

                // Add Additional note.
                $order_details['novalnet_comments'] .= (!empty($response['tid'])) ? $this->language->get('refund_child_tid_msg') . $response['tid'] : '';

                // Update order details in Novalnet tables and shop tables
                $this->model_extension_payment_novalnet->orderDetailsUpdate($order_details, $response['tid_status'], $order_status);

                // Show success message.
                $this->json['success'] = $order_details['novalnet_comments'];
            } else {
                // Show error message.
                $this->json['error'] = $this->getResponseText($response);
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($this->json));
    }

    /**
     * Amount update process for the particular transaction
     *
     * @param       none
     * @return      boolean
     */
    public function amountUpdate() {
        $this->load->language('extension/payment/novalnet_common');
        $this->load->model('extension/payment/novalnet');

        $updated_amount = trim($this->request->post['novalnetAmountUpdate']);

        // Validate updated amount.
        if (!$this->validateAmount($updated_amount)) {
            $this->json['error'] = $this->language->get('error_amount_invalid');
        } else {

            // Get order details.
            $order_details = $this->model_extension_payment_novalnet->getNovalnetOrders($this->request->request['order_id']);

            // Perform Novalnet API process.
            $response = $this->novalnetApiProcess($order_details);

            // Check for valid response.
            if ($this->checkResponseStatus($response)) {
                $this->load->language('extension/payment/' . $order_details['payment_type']);

                $due_date = '';

                if($order_details['payment_id'] == '27') {
                    $due_date = !empty($this->request->post['dueDateUpdate']) ? date($this->language->get('date_format_short'), strtotime($this->request->post['dueDateUpdate'])) : '';
                }
                elseif ($order_details['payment_id'] == '59') {
                    $due_date = !empty($this->request->post['expiryDateUpdate']) ? date($this->language->get('date_format_short'), strtotime($this->request->post['expiryDateUpdate'])) : '';
                }
                // Form comments.
                if($order_details['payment_id'] != '37') {
                    if($order_details['payment_id'] == '59' || $order_details['payment_id'] == '27') {
                        $message = ($order_details['payment_id'] == '27') ? $order_details['novalnet_comments'] = $this->language->get('message_amount_update1') . sprintf("%.2f", $updated_amount / 100) . ' ' . $order_details['transaction_details']['currency'].' ' . sprintf($this->language->get('message_amount_update2'), $due_date) : $order_details['novalnet_comments'] = $this->language->get('message_amount_update1') . sprintf("%.2f", $updated_amount / 100) . ' ' . $order_details['transaction_details']['currency'].' ' . sprintf($this->language->get('message_amount_update3'), $due_date);
                    }
                    else {
                        $message = $order_details['novalnet_comments'] = $this->language->get('message_amount_update1') . sprintf("%.2f", $updated_amount / 100) . ' ' . $order_details['transaction_details']['currency'];
                    }
                }
                else {
                    $message = $order_details['novalnet_comments'] = $this->language->get('sepa_amount_update1') . sprintf("%.2f", $updated_amount / 100) . ' ' . $order_details['transaction_details']['currency'].' ' . sprintf($this->language->get('sepa_amount_update2'), date('Y-m-d'), date('H:i:s'));
                }

                $order_details['transaction_details']['amount'] = $updated_amount;
                $order_details['transaction_details']['total_amount'] = $updated_amount;

                $novalnet_transactions = array(
                    'transaction_details' => "'" . json_encode($order_details['transaction_details']) . "'",
                    'gateway_status' => $response['tid_status'],
                );

                if($order_details['payment_id'] == '27') {
                    $novalnet_response = $order_details['additional_details'];
                    $novalnet_response['tid'] = $order_details['tid'];

                    $order_details['additional_details']['due_date'] = trim($this->request->post['dueDateUpdate']);

                    $novalnet_transactions['additional_details'] = "'" . addslashes(json_encode($order_details['additional_details']))  . "'";
                    $novalnet_response['amount']   = $updated_amount;
                    $novalnet_response['shop_tid'] = $novalnet_response['tid'];
                    $novalnet_response['currency'] = $order_details['transaction_details']['currency'];
                    $novalnet_response['due_date'] = $due_date;
                    $novalnet_response['order_no'] = $this->request->request['order_no'];

                    $invoice_details = array(
                        'amount'    => $order_details['transaction_details']['amount'] / 100,
                        'currency'  => $order_details['transaction_details']['currency'],
                    );
                    $order_details['novalnet_comments'] .= '<br><br>' . $this->prepareNovalnetComments($novalnet_response, $invoice_details, $order_details['payment_type'], $this->request->request['order_no']);
                }
                elseif($order_details['payment_id'] == '59') {
                    $novalnet_response = $order_details['additional_details'];
                    $novalnet_response['tid'] = $order_details['tid'];

                    $order_details['additional_details']['cp_due_date'] = trim($this->request->post['expiryDateUpdate']);

                    $novalnet_transactions['additional_details'] = "'" . addslashes(json_encode($order_details['additional_details']))  . "'";
                    $novalnet_response['amount']   = $updated_amount;
                    $novalnet_response['shop_tid'] = $novalnet_response['tid'];
                    $novalnet_response['currency'] = $order_details['transaction_details']['currency'];
                    $novalnet_response['cp_due_date'] = $due_date;
                    $novalnet_response['order_no'] = $this->request->request['order_no'];

                    $order_details['novalnet_comments'] .= '<br><br>' . $this->prepareBarzahlenComments($due_date,  $this->request->request['order_no']);
                }

                // Update amount and gateway status in transaction details.
                $this->model_extension_payment_novalnet->dbUpdate('novalnet_transactions', $novalnet_transactions, 'order_no=' . $this->request->request['order_no']);

                // Update order details in Novalnet tables and shop tables
                $this->model_extension_payment_novalnet->orderDetailsUpdate($order_details, $response['tid_status'], $this->getOrderStatus());

                // Show success message.
                $this->json['success'] = $message;
            } else {
                // Show error message.
                $this->json['error'] = $this->getResponseText($response);
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($this->json));
    }

    /**
     * Prepare Novalnet transaction comments
     *
     * @param  $response
     * @param  $order_info
     * @param  $payment_name
     * @param  $order_id
     * @return string
     */
    public function prepareNovalnetComments($response, $order_info, $payment_name, $order_id)
    {
	$response['invoice_account_holder'] = 'Novalnet AG';	
        $novalnet_comments = $this->language->get('text_' . $payment_name . '_title') . '<br>';
        $novalnet_comments .= $this->language->get('text_novalnet_TID') . $response['tid'] . '<br>';
        $novalnet_comments .= ((!empty($response['test_mode']) && $response['test_mode'] == 1) || $this->config->get('payment_'.$payment_name . '_testmode') != 'no') ? $this->language->get('text_novalnet_test_order') : '';
        if (in_array($payment_name, array('novalnet_prepayment', 'novalnet_invoice'))) {
            $novalnet_comments .= '<br><br>' . $this->language->get('text_novalnet_comments') . '<br>';
            $novalnet_comments .= $this->language->get('text_novalnet_due_date') . $response['due_date'] . '<br>';
            $novalnet_comments .= $this->language->get('text_novalnet_account_holder') . $response['invoice_account_holder'] . '<br>';
            $novalnet_comments .= $this->language->get('text_novalnet_iban') . $response['invoice_iban'] . '<br>';
            $novalnet_comments .= $this->language->get('text_novalnet_bic') . $response['invoice_bic'] . '<br>';
            $novalnet_comments .= $this->language->get('text_novalnet_bank') . $response['invoice_bankname'] . ' ' . $response['invoice_bankplace'] . '<br>';
            $novalnet_comments .= $this->language->get('text_novalnet_amount') . ($this->currency->format($order_info['amount'], $order_info['currency'], '1')) . '<br><br>';
            $novalnet_comments .= $this->language->get('text_novalnet_reference_any_one') . '<br>';
			$novalnet_comments .= $this->language->get('text_novalnet_reference') . ' 1: TID ' . $response['tid'] . '<br/>';
			$novalnet_comments .= $this->language->get('text_novalnet_reference') . ' 2: BNR-' . trim($this->config->get('payment_novalnet_project_id')) . '-' . $order_id;
        }
        return $novalnet_comments;
    }

    /**
     * Prepare Barzahlen payment comments
     *
     * @param  $due_date
     * @param  $order_no
     * @return string
     */

    public function prepareBarzahlenComments($due_date, $order_no) {
        $db_details = $this->db->query('SELECT comment FROM ' . DB_PREFIX . 'order_history WHERE order_id = '.$order_no.' order by `order_history_id` asc limit 1');
        $order_details = explode('<br>', $db_details->row['comment']);
        $order_details['3'] =  $this->language->get('text_slip_expiry_date') . ': '.$due_date;
        $novalnet_comments = implode('<br>', $order_details);
        return $novalnet_comments;
    }

    /**
     * Amount booking process for the particular transaction
     *
     */
    public function amountBooking() {

        // Load language content.
        $this->load->language('extension/payment/novalnet_common');

        // Load Novalnet model.
        $this->load->model('extension/payment/novalnet');

        // Get order details.
        $order_details = $this->model_extension_payment_novalnet->getNovalnetOrders($this->request->request['order_id']);
        $order_details['transaction_details']['amount']       = $this->request->post['booking_amount'];

        // Validate amount.
        if (!$this->validateAmount($order_details['transaction_details']['amount'])) {
            $this->json['error'] = $this->language->get('empty_booking_amount');
        } else {

            // Perform Novalnet API process.
            $response = $this->novalnetApiProcess($order_details);

            // Check for valid response.
            if ($this->checkResponseStatus($response)) {

                $this->load->language('extension/payment/' . $order_details['payment_type']);

                // Prepare transaction comments.
                $order_details['comments'] = $this->prepareNovalnetComments($response, $order_details['transaction_details'], $order_details['payment_type'], $this->request->request['order_no']);

                // Prepare notification message.
                $notification_message = $this->language->get('confirm_booking1') . $this->currency->format($order_details['transaction_details']['amount'] / 100, $order_details['transaction_details']['currency'], '1') . ' ' . $this->language->get('confirm_booking2') . $response['tid'];
                $order_details['comments'] .= '<br><br>' . $notification_message;

                $this->model_extension_payment_novalnet->updateBookingDetails($response, $order_details);
                $this->json['success'] = $notification_message;
            } else {

                // if the server response status is not 100, then display error message
                $this->json['error'] = $this->getResponseText($response);
            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($this->json));
    }

    /**
     * To validate amount
     *
     * @param  $amount
     * @return boolean
     */
    public function validateAmount($amount) {
        return !empty($amount) && ($amount > 0);
    }

    /**
     * To check status of the response
     *
     * @param  $response
     * @param  $key
     * @param  $status
     * @return boolean
     */
    public function checkResponseStatus($response, $key = 'status' , $status = '100') {
        return !empty($response[$key]) && $response[$key] == $status;
    }

	 /**
     * To get the remote/server IP address
     *
     * @param       string $type
     * @return      string
     */

    public function getIpAddress($type = 'REMOTE_ADDR') {
		// Check to determine the IP address type
		if ($type == 'SERVER_ADDR') {
			if (empty($_SERVER['SERVER_ADDR'])) {
				// Handled for IIS server
				$ip_address = gethostbyname($_SERVER['SERVER_NAME']);
			} else {
				$ip_address =$this->request->server['SERVER_ADDR'];
			}
		} else { // For remote address
			$ip_address = $this->getRemoteAddress();
		}

		return $ip_address;
	}

	 /**
     * To get the remote IP address
     * @return string
     */

	public function getRemoteAddress()
	{
		$ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
		foreach ($ip_keys as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					// trim for safety measures
					return trim($ip);
				}
			}
		}
	}

    /**
     * Recurring cancel process.
     *
     * @param  none
     * @return boolean
     */
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
     * Send Guaranteed invoice payment confirmation mail to end customer
     *
     * @param       $order_id
     * @param       $transaction_comments
     * @return      none
     */
    
    public function sendPaymentNotificationMail($order_id , $transaction_comments)
    {
		$get_customer_details = $this->model_extension_payment_novalnet->dbSelect('order', 'customer_id, firstname, lastname, email', 'order_id =' . $order_id);
		if (!empty($get_customer_details['email'])) {
			$shop_name = !empty($this->config->get('config_name')) ? $this->config->get('config_name') : '';
            $email_from		  = $this->config->get('config_email');
            $email_to         = $get_customer_details['email'];
            $email_subject    = 'Order Confirmation - Your Order '.$order_id.' with '.$shop_name.' has been confirmed!';
            $email_content    = '<body style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; margin:0; padding:0;">
									<div style="width:55%;height:auto;margin: 0 auto;background:rgb(247, 247, 247);border: 2px solid rgb(223, 216, 216);border-radius: 5px;box-shadow: 1px 7px 10px -2px #ccc;">
										<div style="min-height: 300px;padding:20px;">
											<table cellspacing="0" cellpadding="0" border="0" width="100%">

												<tr><b>Dear Mr./Ms./Mrs.</b> '.$get_customer_details['firstname'].' '.$get_customer_details['lastname'].' </tr></br></br>

												<tr>We are pleased to inform you that your order has been confirmed.</tr></br></br>

												<tr><b>Subject:</b> Order Confirmation - Your Order '.$order_id.' with '.$shop_name.' has been confirmed!</tr></br></br>

												<tr><b>Payment Information:</b></br> </br>        
												'.$transaction_comments.'
												</tr></br>                                            

											</table>
										</div>
										<div style="width:100%;height:20px;background:#00669D;"></div>
									</div>
								</body>';           
            // Send Callback notification E-mail.
            if (preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email_to)) {
                $mail = new Mail();
                $mail->setTo($email_to);
                $mail->setFrom($email_from);
                $mail->setSender($email_from);
                $mail->setSubject($email_subject);
                $mail->setHtml($email_content);
                $mail->send();
            }
        } else {
			echo 'Mail not send';
			exit;
		}		
	}
}
