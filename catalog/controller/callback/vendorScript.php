<?php
/**
 *
 * Novalnet vendor script module
 * This module is used for real time processing of
 * Payments in novalnet.
 *
 * Copyright (c) Novalnet
 *
 * Released under the GNU General Public License
 * This free contribution made by request.
 * If you have found this script useful a small
 * recommendation as well as a comment on merchant form
 * would be greatly appreciated.
 *
 * Script : vendorScript.php
 *
 * @author    Novalnet AG
 * @copyright Copyright by Novalnet
 * @license   https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 *
 */

class ControllerCallbackVendorScript extends Controller
{
    /** @Array Type of payment available - Level : 0 */
    protected $payments = array(
        'CREDITCARD',
        'INVOICE_START',
        'DIRECT_DEBIT_SEPA',
        'GUARANTEED_INVOICE',
        'GUARANTEED_DIRECT_DEBIT_SEPA',
        'PAYPAL',
        'ONLINE_TRANSFER',
        'IDEAL',
        'EPS',
        'PRZELEWY24',
        'GIROPAY',
        'CASHPAYMENT',
    );

    /** @Array Type of Chargebacks available - Level : 1 */
    protected $chargebacks = array(
        'RETURN_DEBIT_SEPA',
        'REVERSAL',
        'CREDITCARD_BOOKBACK',
        'CREDITCARD_CHARGEBACK',
        'PAYPAL_BOOKBACK',
        'REFUND_BY_BANK_TRANSFER_EU',
        'PRZELEWY24_REFUND',
        'CASHPAYMENT_REFUND',
        'GUARANTEED_INVOICE_BOOKBACK',
        'GUARANTEED_SEPA_BOOKBACK',
    );

    /** @Array Type of CreditEntry payment and Collections available - Level : 2 */
    protected $collections = array(
        'INVOICE_CREDIT',
        'CASHPAYMENT_CREDIT',
        'CREDIT_ENTRY_CREDITCARD',
        'CREDIT_ENTRY_SEPA',
        'DEBT_COLLECTION_SEPA',
        'DEBT_COLLECTION_CREDITCARD',
        'ONLINE_TRANSFER_CREDIT',
        'CREDIT_ENTRY_DE',
        'DEBT_COLLECTION_DE'
    );

    /** @Array Novalnet subscriptions catagory */
    protected $subscriptions = array(
        'SUBSCRIPTION_STOP',
        'SUBSCRIPTION_PAUSE',
        'SUBSCRIPTION_UPDATE',
        'SUBSCRIPTION_REACTIVATE'
    );

    /** @Array Novalnet payments catagory */
    protected $payment_group = array(
        'novalnet_cc' => array(
            'CREDITCARD',
            'CREDITCARD_BOOKBACK',
            'CREDITCARD_CHARGEBACK',
            'CREDIT_ENTRY_CREDITCARD',
            'DEBT_COLLECTION_CREDITCARD',
            'SUBSCRIPTION_STOP',
            'SUBSCRIPTION_REACTIVATE',
            'TRANSACTION_CANCELLATION',
        ),
        'novalnet_sepa' => array(
            'DIRECT_DEBIT_SEPA',
            'RETURN_DEBIT_SEPA',
            'SUBSCRIPTION_STOP',
            'SUBSCRIPTION_REACTIVATE',
            'DEBT_COLLECTION_SEPA',
            'CREDIT_ENTRY_SEPA',
            'GUARANTEED_DIRECT_DEBIT_SEPA',
            'GUARANTEED_SEPA_BOOKBACK',
            'REFUND_BY_BANK_TRANSFER_EU',
            'TRANSACTION_CANCELLATION'
        ),
        'novalnet_ideal' => array(
            'IDEAL',
            'REFUND_BY_BANK_TRANSFER_EU',
            'ONLINE_TRANSFER_CREDIT',
            'REVERSAL',
            'CREDIT_ENTRY_DE',
            'DEBT_COLLECTION_DE',
        ),
        'novalnet_instant_bank_transfer' => array(
            'ONLINE_TRANSFER',
            'REFUND_BY_BANK_TRANSFER_EU',
            'ONLINE_TRANSFER_CREDIT',
            'REVERSAL',
            'CREDIT_ENTRY_DE',
            'DEBT_COLLECTION_DE',
        ),

        'novalnet_paypal' => array(
            'PAYPAL',
            'SUBSCRIPTION_STOP',
            'SUBSCRIPTION_REACTIVATE',
            'PAYPAL_BOOKBACK',
            'TRANSACTION_CANCELLATION',
            
        ), 'novalnet_prepayment' => array(
            'INVOICE_START',
            'INVOICE_CREDIT',
            'SUBSCRIPTION_STOP',
            'SUBSCRIPTION_REACTIVATE',
            'REFUND_BY_BANK_TRANSFER_EU',
        ),
        'novalnet_invoice' => array(
            'INVOICE_START',
            'GUARANTEED_INVOICE',
            'GUARANTEED_INVOICE_BOOKBACK',
            'INVOICE_CREDIT',
            'SUBSCRIPTION_STOP',
            'SUBSCRIPTION_REACTIVATE',
            'REFUND_BY_BANK_TRANSFER_EU',
            'TRANSACTION_CANCELLATION',
            'CREDIT_ENTRY_DE',
            'DEBT_COLLECTION_DE',
        ),
        'novalnet_eps' => array(
            'EPS',
            'REFUND_BY_BANK_TRANSFER_EU',
            'ONLINE_TRANSFER_CREDIT',
            'REVERSAL',
            'CREDIT_ENTRY_DE',
            'DEBT_COLLECTION_DE',
        ),
        'novalnet_giropay' => array(
            'GIROPAY',
            'REFUND_BY_BANK_TRANSFER_EU',
            'ONLINE_TRANSFER_CREDIT',
            'REVERSAL',
            'CREDIT_ENTRY_DE',
            'DEBT_COLLECTION_DE',
        ),
        'novalnet_przelewy24' => array(
            'PRZELEWY24',
            'PRZELEWY24_REFUND',
            'TRANSACTION_CANCELLATION'
        ),
        'novalnet_cashpayment' => array(
            'CASHPAYMENT',
            'CASHPAYMENT_CREDIT',
            'CASHPAYMENT_REFUND'
        )
    );

    /** @Array  Mandatory Parameters */
    protected $required_params = array(
        'vendor_id',
        'tid',
        'payment_type',
        'status'
    );

    /** @Array Captured parameters */
    protected $capture_params = array();

    /** @Array Get transaction details */
    protected $transaction_history = array();

    /** @Array Novalnet success codes */
    protected $success_code = array(
        'PAYPAL'                       => array(
            '100',
            '90',
            '85'
        ),
        'INVOICE_START'                => array(
            '100',
            '91'
        ),
        'GUARANTEED_INVOICE'           => array(
            '100',
            '91',
            '75'
        ),
        'CREDITCARD'                   => array(
            '100',
            '98'
        ),
        'DIRECT_DEBIT_SEPA'            => array(
            '100',
            '99'
        ),
        'GUARANTEED_DIRECT_DEBIT_SEPA' => array(
            '100',
            '99',
            '75',
        ),
        'ONLINE_TRANSFER'              => array(
            '100'
        ),
        'GIROPAY'                      => array(
            '100'
        ),
        'IDEAL'                        => array(
            '100'
        ),
        'EPS'                          => array(
            '100'
        ),
        'PRZELEWY24'                   => array(
            '86',
            '100'
        ),
        'CASHPAYMENT'                   => array(
            '100'
        )

    );

    /**
     * Initiate the vendor script process
     *
     * @param       none
     * @return      none
     */
    public function index()
    {
        // Load language content.
        $this->language->load('callback/vendorScript');

        // Load Novalnet model.
        $this->load->model('extension/payment/novalnet');

        // Get Novalnet callback configuration.
        $this->test_mode      = $this->config->get('payment_novalnet_callback_testmode');

        // Get requested parameters.
        $this->capture_params = array_map('trim', $_REQUEST);

        // Authenticating the server request based on IP.
        $this->validateIpAddress();

        if (!empty($this->capture_params['payment_type']) && $this->capture_params['payment_type'] != 'SUBSCRIPTION_STOP') {
            array_push($this->required_params, 'amount');
        }
        // Get Parent TID.
        $this->capture_params['shop_tid'] = !empty($this->capture_params['tid']) ? $this->capture_params['tid'] : '';
        if (!empty($this->capture_params['subs_billing']) && $this->capture_params['subs_billing'] == 1) {
            array_push($this->required_params, 'signup_tid');
            $this->capture_params['shop_tid'] = $this->capture_params['signup_tid'];
        } elseif (!empty($this->capture_params['payment_type']) && in_array($this->capture_params['payment_type'], array_merge($this->chargebacks, $this->collections))) {
            array_push($this->required_params, 'tid_payment');
            $this->capture_params['shop_tid'] = $this->capture_params['tid_payment'];
        }
        // Validate request parameters.
        $this->validateCaptureParameters();
        
        $this->load->model('account/order');
        $order_details = $this->model_account_order->getOrderProducts($this->capture_params['order_no']);            
        
        // Order number check.
        if ( empty( $order_details ) ) {
            $this->send_critical_error_mail();
            $this->displayMessage( 'Novalnet callback script order number not valid' );
        }
        // Get order details.
        $this->transaction_history = $this->getOrderDetails();
        if (!empty($this->transaction_history)) {

            $check_status_code = ($this->capture_params['status'] == '100' && $this->capture_params['tid_status'] == '100');

            // Transaction cancellation process.
            $this->transaction_cancellation();

            // Handle second level process.
            if ($this->transaction_history['payment_level'] == 2 && $check_status_code) {
                $this->secondLevelProcess();
            }

            // Handle first level process.
            if ($this->transaction_history['payment_level'] == 1 && $check_status_code) {
                $this->firstLevelProcess();
            }

            // Handle zero level process.
            if ($this->transaction_history['payment_level'] == 0 && $this->success_code[$this->capture_params['payment_type']]) {
                $this->zeroLevelProcess();
            }
            

            if (($this->capture_params['status'] != '100' || $this->capture_params['tid_status'] != '100') && $this->capture_params['payment_type'] != 'novalnet_przelewy24') {
                $this->displayMessage('Novalnet callback received. Status (' . $this->capture_params['status'] . ') is not valid');
            } else {
                $this->displayMessage('Novalnet callback script executed already');
            }
        } else {
            $this->displayMessage('Order Reference not exist!');
        }
    }

    /**
     * Perform level 2 payment process
     *
     * @param       none
     * @return      none
     */
    public function secondLevelProcess()
    {
        if (in_array($this->capture_params['payment_type'], array('CREDIT_ENTRY_CREDITCARD', 'DEBT_COLLECTION_CREDITCARD', 'CREDIT_ENTRY_SEPA', 'DEBT_COLLECTION_SEPA', 'GUARANTEED_DEBT_COLLECTION_SEPA', 'CREDIT_ENTRY_DE', 'DEBT_COLLECTION_DE'))) {
           $callback_comments       = $this->language->get('text_success_callback1') . $this->capture_params['shop_tid'] . $this->language->get('text_success_callback2') . sprintf('%.2f', ($this->capture_params['amount'] / 100)) . ' ' . $this->capture_params['currency'] . $this->language->get('text_success_callback3') . date('Y-m-d H:i:s') . $this->language->get('text_success_callback4') . $this->capture_params['tid'];
           // Update callback comments.
            $this->updateCallbackComments(array(
                'order_no' => $this->transaction_history['order_no'],
                'comments' => $callback_comments,
                'orders_status_id' => $this->transaction_history['current_order_status']
            ));              
            // Send notification mail.
            $this->sendNotificationMail($callback_comments);
            $this->displayMessage($callback_comments);
        }
        if (isset($this->transaction_history['order_paid_amount']) && isset($this->transaction_history['transaction_details']['total_amount']) && $this->transaction_history['order_paid_amount'] < $this->transaction_history['transaction_details']['total_amount']) {
            // Form callback comments.
            $callback_comments       = $this->language->get('text_success_callback1') . $this->capture_params['shop_tid'] . $this->language->get('text_success_callback2') . sprintf('%.2f', ($this->capture_params['amount'] / 100)) . ' ' . $this->capture_params['currency'] . $this->language->get('text_success_callback3') . date('Y-m-d H:i:s') . $this->language->get('text_success_callback4') . $this->capture_params['tid'];


            $total_paid_amount = ($this->transaction_history['order_paid_amount'] + $this->capture_params['amount']);

            $paid_status = 'unpaid';

            // Check for total paid amount.
            if ($this->transaction_history['transaction_details']['total_amount'] <= $total_paid_amount) {

                $paid_status = 'paid';

                // Get callback order status ID.
                $callback_status_id = (!empty($this->transaction_history['callback_order_status'])) ? $this->transaction_history['callback_order_status'] : $this->config->get('payment_'.$this->transaction_history['payment_type'] . '_order_completion_status');

                if ($this->capture_params['payment_type'] != 'ONLINE_TRANSFER_CREDIT') {

                    // Update order status for the order.
                    $this->model_extension_payment_novalnet->dbUpdate('order', array(
                        'order_status_id' => $callback_status_id
                    ), 'order_id=' . $this->transaction_history['order_no']);

                    // Update Transaction status for the order in Novalnet table.prepareNovalnetComments
                    $this->model_extension_payment_novalnet->dbUpdate('novalnet_transactions', array(
                        'gateway_status' => $this->capture_params['tid_status']
                    ), 'order_no=' . $this->transaction_history['order_no']);
                }
            } else {
                $callback_status_id = $this->transaction_history['current_order_status'];
            }

            $recurring_details = $this->model_extension_payment_novalnet->dbSelect('novalnet_recurring_transactions', 'transaction_details', 'tid =' . $this->capture_params['shop_tid']);
            if(empty($recurring_details['transaction_details'])){
                // Update callback comments.
                $this->updateCallbackComments(array(
                    'order_no' => $this->transaction_history['order_no'],
                    'comments' => $callback_comments,
                    'orders_status_id' => $callback_status_id
                ));
            } else {
                // Update callback comments for the order in Novalnet recurring transaction table.
                $this->model_extension_payment_novalnet->dbUpdate('novalnet_recurring_transactions', array(
                    'transaction_details' => '"' . $recurring_details['transaction_details'] . '<br>' . $callback_comments . '<br>' . '"' ,
                    'status'    => '"' . $paid_status . '"'
                ), 'tid =' . $this->capture_params['shop_tid']);
            }

            // Log callback process.
            $this->logCallbackProcess();

            // Send notification mail.
            $this->sendNotificationMail($callback_comments);
            $this->displayMessage($callback_comments);
        }
        $this->displayMessage('Callback Script executed already. Refer Order :' . (!empty($this->transaction_history['order_no']) ? $this->transaction_history['order_no'] : ''));
    }

    /**
     * Perform level 1 payment process
     *
     * @param       none
     * @return      none
     */
    public function firstLevelProcess()
    {
        $comments    = (in_array($this->capture_params['payment_type'], array(
            'CREDITCARD_BOOKBACK',
            'PAYPAL_BOOKBACK',
            'REFUND_BY_BANK_TRANSFER_EU',
            'PRZELEWY24_REFUND',
            'CASHPAYMENT_REFUND',
            'GUARANTEED_INVOICE_BOOKBACK',
            'GUARANTEED_SEPA_BOOKBACK'
        ))) ? $this->language->get('text_bookback') : $this->language->get('text_chargeback1');

        // Form callback comments.
        $callback_comments  = $comments . $this->capture_params['tid_payment'] . $this->language->get('text_chargeback2') . sprintf('%.2f', ($this->capture_params['amount'] / 100)) . ' ' . $this->capture_params['currency'] . $this->language->get('text_success_callback3') . date("Y-m-d H:i:s") . $this->language->get('text_chargeback4') . $this->capture_params['tid'];

        // Log callback process.
        $this->logCallbackProcess();

        $recurring_details = $this->model_extension_payment_novalnet->dbSelect('novalnet_recurring_transactions', 'transaction_details', 'tid =' . $this->capture_params['shop_tid']);
        if(empty($recurring_details['transaction_details'])){

            // Update callback comments.
            $this->updateCallbackComments(array(
                'order_no' => $this->transaction_history['order_no'],
                'comments' => $callback_comments,
                'orders_status_id' => $this->transaction_history['current_order_status']
            ));
        } else {
            // Update callback comments for the order in Novalnet recurring transaction table.
            $this->model_extension_payment_novalnet->dbUpdate('novalnet_recurring_transactions', array(
                'transaction_details' => '"' . $recurring_details['transaction_details'] . '<br><br>' . $callback_comments . '"',
            ), 'tid =' . $this->capture_params['shop_tid']);
        }
        // Send notification mail.
        $this->sendNotificationMail($callback_comments);
        $this->displayMessage($callback_comments);
    }

    /**
     * Perform level 0 payment process
     *
     * @param       none
     * @return      none
     */
    public function zeroLevelProcess()
    {
        if(in_array($this->capture_params['payment_type'], array('INVOICE_START', 'DIRECT_DEBIT_SEPA', 'GUARANTEED_INVOICE', 'GUARANTEED_DIRECT_DEBIT_SEPA', 'CREDITCARD', 'PAYPAL')) && in_array($this->transaction_history['gateway_status'], array(75, 91, 99, 98, 85)) && in_array($this->capture_params['tid_status'], array(91, 99, 100))) {
            // Get order information
            $order_info = $this->model_extension_payment_novalnet->dbSelect('order', 'total, currency_value, currency_code', 'order_id =' . $this->transaction_history['order_no']);            
            $comments = '';
            if($this->capture_params['tid_status'] == 100 && $this->capture_params['status'] == 100 && in_array($this->transaction_history['gateway_status'], array(91, 99, 98, 85))) {

                $order_status =($this->capture_params['payment_type'] == 'GUARANTEED_INVOICE') ? $this->config->get('payment_'.$this->transaction_history['payment_type'] . '_callback_order_status') : $this->config->get('payment_'.$this->transaction_history['payment_type'] . '_order_completion_status');
                // Update order status ID in shop order table.
                $this->model_extension_payment_novalnet->dbUpdate('order', array(
                'order_status_id' => $order_status
                ), 'order_id=' . $this->transaction_history['order_no']);
                if(in_array($this->capture_params['payment_type'], array('INVOICE_START', 'GUARANTEED_INVOICE'))) {
					$callback = true;
                    $comments = $this->model_extension_payment_novalnet->prepareTransactionComments($this->capture_params, $this->transaction_history['payment_type']);
                    $comments .= $this->model_extension_payment_novalnet->prepareNovalnetComments($this->capture_params, $order_info,$callback);
                    if ($this->capture_params['payment_type'] == 'GUARANTEED_INVOICE') {
						$this->sendPaymentNotificationMail($this->transaction_history['order_no'], $comments);
					}
                }
            } else if($this->capture_params['payment_type'] == 'GUARANTEED_INVOICE' && $this->transaction_history['gateway_status'] == 75 && in_array($this->capture_params['tid_status'], array(91,100))) {
                $order_status = ($this->capture_params['tid_status'] == 100) ? $this->config->get('payment_'.$this->transaction_history['payment_type'] . '_callback_order_status') : $this->config->get('payment_novalnet_onhold_complete_status');
                // Update order status ID in shop order table.
                $this->model_extension_payment_novalnet->dbUpdate('order', array(
                'order_status_id' => $order_status
                ), 'order_id=' . $this->transaction_history['order_no']);
                // Re-generate invoice comments 
                $callback = true;
                $comments .= $this->model_extension_payment_novalnet->prepareTransactionComments($this->capture_params, $this->transaction_history['payment_type']);
                $comments .= $this->model_extension_payment_novalnet->prepareNovalnetComments($this->capture_params, $order_info, $callback); 
                $this->sendPaymentNotificationMail($this->transaction_history['order_no'], $comments);
            } else if($this->capture_params['payment_type'] == 'GUARANTEED_DIRECT_DEBIT_SEPA' && $this->transaction_history['gateway_status'] == 75 && in_array($this->capture_params['tid_status'], array(99,100))) {
                $order_status = ($this->capture_params['tid_status'] == 100) ?  $this->config->get('payment_'.$this->transaction_history['payment_type'] . '_order_completion_status') : $this->config->get('payment_novalnet_onhold_complete_status');
                // Update order status ID in shop order table.
                $this->model_extension_payment_novalnet->dbUpdate('order', array(
                'order_status_id' => $order_status
                ), 'order_id=' . $this->transaction_history['order_no']);
                $this->sendPaymentNotificationMail($this->transaction_history['order_no'], $comments);
            } else {                    
                $this->displayMessage('Novalnet callback script executed already');
            }
            if($this->transaction_history['gateway_status'] == 75 && in_array($this->capture_params['tid_status'], array(91, 99))) {
                $comments .= '<br>' .$this->language->get('text_guarantee_pending_to_onhold_message') . $this->capture_params['shop_tid'] . $this->language->get('text_success_callback3') . date('Y-m-d H:i:s');
            }else if(in_array($this->transaction_history['gateway_status'], array(75, 91, 99, 98, 85)) && $this->capture_params['tid_status'] == 100) {
                $comments .= 'The transaction has been confirmed  successfully for the TID: ' .$this->capture_params['shop_tid'].  ' on '. date('Y-m-d H:i:s');
            }
            
            // Update Transaction status in Novalnet table.
            $this->model_extension_payment_novalnet->dbUpdate('novalnet_transactions', array(
            'gateway_status' => $this->capture_params['tid_status']                 
            ), 'order_no=' . $this->transaction_history['order_no']);
            // Update callback comments.
            $this->updateCallbackComments(array(
            'order_no' => $this->transaction_history['order_no'],
            'comments' => $comments,
            'orders_status_id' => $order_status
            ));

            // Send notification mail.
            $this->sendNotificationMail($comments);
            $this->displayMessage($comments);           
        } else if (in_array($this->capture_params['payment_type'], array( 'PAYPAL', 'PRZELEWY24' )) && $this->capture_params['tid_status'] == '100') {
            if (empty($this->transaction_history['order_paid_amount'])) {
                // Form callback comments.
                $callback_comments      = $this->language->get('text_success_callback1') . $this->capture_params['shop_tid'] . $this->language->get('text_success_callback2') . sprintf('%.2f', ($this->capture_params['amount'] / 100)) . ' ' . $this->capture_params['currency'] . $this->language->get('text_success_callback3') . date('Y-m-d H:i:s');

                $callback_status = $this->config->get('payment_'.$this->transaction_history['payment_type'] . '_order_completion_status');

                // Update order status ID in shop order table.
                $this->model_extension_payment_novalnet->dbUpdate('order', array(
                    'order_status_id' => $callback_status
                ), 'order_id=' . $this->transaction_history['order_no']);

                $this->transaction_history['transaction_details']['total_amount'] = $this->transaction_history['transaction_details']['amount'] = $this->capture_params['amount'];

                // Update Transaction status in Novalnet table.
                $this->model_extension_payment_novalnet->dbUpdate('novalnet_transactions', array(
                    'gateway_status' => $this->capture_params['tid_status'],
                    'transaction_details' => "'" . json_encode($this->transaction_history['transaction_details']) . "'"
                ), 'order_no=' . $this->transaction_history['order_no']);
                // Update callback comments.
                $this->updateCallbackComments(array(
                    'order_no' => $this->transaction_history['order_no'],
                    'comments' => $callback_comments,
                    'orders_status_id' => $callback_status
                ));
                // Log callback process.
                $this->logCallbackProcess();
                // Send notification mail.
                $this->sendNotificationMail($callback_comments);
                $this->displayMessage($callback_comments);
            }
            $this->displayMessage('Novalnet Callbackscript received. Order already Paid');
        } else if($this->capture_params['payment_type'] == 'PRZELEWY24' && !in_array($this->capture_params['tid_status'], array('86', '100'))) {
            $callback_comments = $this->language->get('transaction_cancel_message') . (!empty($this->capture_params['status_message']) ? $this->capture_params['status_message'] : (!empty($this->capture_params['status_text']) ? $this->capture_params['status_text'] : (!empty($this->capture_params['status_desc']) ? $this->capture_params['status_desc'] : $this->language->get('text_novalnet_error_code')) ));
            // Update callback comments.
                $this->updateCallbackComments(array(
                    'order_no' => $this->transaction_history['order_no'],
                    'comments' => $callback_comments,
                    'orders_status_id' => $this->config->get('payment_novalnet_cancel_status')
                ));
                $this->displayMessage($callback_comments);
        } else {
            $this->displayMessage('Novalnet Callbackscript received. Payment type ( ' . $this->capture_params['payment_type'] . ' ) is not applicable for this process!');
        }
    }

    /**
     * Log callback process in novalnet_callback_history table
     *
     * @param       none
     * @return      none
     */
    public function logCallbackProcess()
    {
        $original_tid = !empty($this->transaction_history['tid']) ? $this->transaction_history['tid'] : $this->capture_params['tid'];
        $this->model_extension_payment_novalnet->dbInsert('novalnet_merchant_script', array(
            'order_no',
            'original_tid',
            'callback_tid',
            'payment_type',
            'amount',
            'date'
        ), array(
            $this->db->escape($this->transaction_history['order_no']),
            $this->db->escape($original_tid),
            $this->db->escape($this->capture_params['tid']),
            "'" . $this->db->escape($this->transaction_history['payment_type']) . "'",
            $this->db->escape($this->capture_params['amount']),
            "'" . date('Y-m-d H:i:s') . "'"
        ));
    }

    /**
     * Get order details
     *
     * @param       none
     * @return      array
     */
    public function getOrderDetails()
    {
        // Get Transaction details.
        $selected_details = $this->model_extension_payment_novalnet->dbSelect('novalnet_transactions', 'order_no, transaction_details, gateway_status, payment_type', 'tid =' . $this->capture_params['shop_tid']);
        if(!empty($selected_details['transaction_details'])) {
            $selected_details['transaction_details'] =  (array)json_decode($selected_details['transaction_details']);
        }
        $order_id = !empty($this->capture_params['order_no']) ? $this->capture_params['order_no'] : '';
        if (empty($selected_details)) {
            // Handle communication failure.
            $this->communicationFailureProcess($order_id);
            // Handle online transfer credit.
            if($this->capture_params['payment_type'] == 'ONLINE_TRANSFER_CREDIT'){
                $selected_details = $this->model_extension_payment_novalnet->dbSelect('novalnet_transactions', 'order_no, transaction_details, payment_type', 'tid =' . $this->capture_params['shop_tid']);
                if(!empty($selected_details['transaction_details'])) {
                    $selected_details['transaction_details'] =  (array)json_decode($selected_details['transaction_details']);
                }
            }
        }
        // Validate order number.
        if (!empty($selected_details['order_no']) && !empty($order_id) && $order_id != $selected_details['order_no']) {
            $this->displayMessage('Novalnet callback received. Order Number is not valid.');
        }
        // Validate Payment type.
        if (!empty($selected_details['payment_type']) && !in_array($this->capture_params['payment_type'], $this->payment_group[$selected_details['payment_type']])) {
            $this->displayMessage('Novalnet callback received. Payment Type [' . $this->capture_params['payment_type'] . '] is not valid.');
        }
        // Assign further Transaction details.
        if (!empty($selected_details['order_no'])) {
            $selected_details['tid']                  = $this->capture_params['shop_tid'];
            $selected_details['current_order_status'] = $this->getCurrentOrderStatus($selected_details['order_no']);
            $selected_details['callback_amount']      = $this->capture_params['amount'];
            if (in_array($selected_details['payment_type'], array(
                'novalnet_invoice',
                'novalnet_prepayment',
                'novalnet_cashpayment',
            ))) {
                $selected_details['callback_order_status'] = $this->config->get('payment_'.$selected_details['payment_type'] . '_callback_order_status');
            }
            $selected_details['order_paid_amount'] = 0;

            // Get payment level.
            $selected_details['payment_level'] = $this->getPaymentLevelType();
            if (in_array($selected_details['payment_level'], array(
                0,
                2
            ))) {
                $paid_amount = $this->model_extension_payment_novalnet->dbSelect('novalnet_merchant_script', 'sum(amount) as amount_total', 'original_tid =' . $selected_details['tid']);
                $selected_details['order_paid_amount'] = $paid_amount['amount_total'];
            }
        }
        return $selected_details;
    }

    /**
     * Get current order status
     *
     * @param       $order_id
     * @return      mixed
     */
    public function getCurrentOrderStatus($order_id)
    {
        $result = $this->model_extension_payment_novalnet->dbSelect('order', 'order_status_id', 'order_id =' . $order_id);
        return (!empty($result['order_status_id'])) ? $result['order_status_id'] : '';
    }

    /**
     * Get payment level type
     *
     * @param       none
     * @return      integer
     */
    public function getPaymentLevelType()
    {
        if (in_array($this->capture_params['payment_type'], $this->payments)) {
            return 0;
        } elseif (in_array($this->capture_params['payment_type'], $this->chargebacks)) {
            return 1;
        } elseif (in_array($this->capture_params['payment_type'], $this->collections)) {
            return 2;
        }
    }

    /**
     * Perform communication failure process
     *
     * @param       $order_id
     * @return      none
     */
    public function communicationFailureProcess($order_id)
    {
        if ($order_id) {
            $selected_details = $this->model_extension_payment_novalnet->dbSelect('order', 'customer_id, payment_code', 'order_id =' . $order_id);
            $payment_type        = $selected_details['payment_code'];
            if (!in_array($this->capture_params['payment_type'], $this->payment_group[$payment_type])) {
                $this->displayMessage('Novalnet callback received. Payment Type [' . $this->capture_params['payment_type'] . '] is not valid.');
            }
                if (!empty($this->capture_params['subs_id'])) {
                    $this->model_extension_payment_novalnet->dbInsert('novalnet_subscriptions', array(
                        'subs_id',
                        'tid',
                        'signup_date',
                        'order_no',
                        'date'
                    ), array(
                        $this->db->escape($this->capture_params['subs_id']),
                        $this->db->escape($this->capture_params['shop_tid']),
                        "'" . date('Y-m-d H:i:s') . "'",
                        $this->db->escape($order_id),
                        "'" . date('Y-m-d H:i:s') . "'"
                    ));
                }
                $payment_id = $this->getPaymentKey($payment_type);
                $this->insertTransactionDetails(array(
                    'order_no' => $this->capture_params['order_no'],
                    'tid' => $this->capture_params['shop_tid'],
                    'gateway_status' => $this->capture_params['tid_status'],
                    'payment_type' => "'" . $payment_type . "'",
                    'payment_id' => $payment_id,
                    'customer_id' => $selected_details['customer_id'],
                    'transaction_details' => "'" . json_encode(array(
                        'amount' => $this->capture_params['amount'],
                        'total_amount' => $this->capture_params['amount'],
                        'currency' => $this->capture_params['currency'],
                    )) . "'",
                    'date' => "'" . date('Y-m-d H:i:s') . "'"
                ));
                $payment_order_status = '"' . $payment_type . '_order_completion_status"';
                if (($payment_type == 'novalnet_paypal' && $this->capture_params['tid_status'] == 90) || ($payment_type == 'novalnet_przelewy24' && $this->capture_params['tid_status'] == 86)) {
                    $payment_order_status = '"' . $payment_type . '_pending_order_status"';
                }
                $comments   = $this->language->get('text_' . $payment_type . '_title') . PHP_EOL;
                $comments .= $this->language->get('text_novalnet_transactionid') . $this->capture_params['shop_tid'];
                $comments .= ($this->capture_params['test_mode']) ? '<br>' . $this->language->get('text_novalnet_testorder') : '';
                $order_status = $this->config->get('payment_'. $payment_type . '_order_completion_status');
                if ((!empty($this->capture_params['tid_status']) && !in_array($this->capture_params['tid_status'], array( 100, 90, 91, 98, 99, 86, 85 ))) || ($this->capture_params['status'] != 100)) {
                    $order_status = $this->config->get('payment_novalnet_cancel_status');
                    $this->capture_params['amount'] = 0;
                    $comments .= '<br>' . (!empty($this->capture_params['status_message']) ? $this->capture_params['status_message'] : (!empty($this->capture_params['status_text']) ? $this->capture_params['status_text'] : (!empty($this->capture_params['status_desc']) ? $this->capture_params['status_desc'] : $this->language->get('text_novalnet_error_code'))));
                } else {
                    $order_status = $payment_order_status;
                }
                $status_info = array(
                    'orders_status_id' => $order_status,
                    'comments' => $comments,
                    'order_no' => $order_id
                );
                $this->model_extension_payment_novalnet->dbUpdate('order', array(
                    'order_status_id' => $order_status
                ), 'order_id=' . $order_id);
                $this->model_extension_payment_novalnet->dbInsert('novalnet_merchant_script', array(
                    'order_no',
                    'original_tid',
                    'callback_tid',
                    'payment_type',
                    'amount',
                    'date'
                ), array(
                    $this->db->escape($order_id),
                    $this->db->escape($this->capture_params['shop_tid']),
                    $this->db->escape($this->capture_params['shop_tid']),
                    "'" . $this->db->escape($payment_type) . "'",
                    (in_array($payment_type, array('novalnet_invoice', 'novalnet_prepayment', 'novalnet_cashpayment')) || ($payment_type =='novalnet_paypal' && $this->capture_params['tid_status'] == 90 ) || ($this->capture_params['payment_type'] == 'ONLINE_TRANSFER_CREDIT')) ? 0 : $this->db->escape($this->capture_params['amount']),
                    "'" . date('Y-m-d H:i:s') . "'"
                ));
                $this->updateCallbackComments($status_info);
                $order_id                         = $this->capture_params['order_no'];
                $this->transaction_history['tid'] = $this->capture_params['shop_tid'];
                $this->sendNotificationMail($comments);
                if($this->capture_params['payment_type'] != 'ONLINE_TRANSFER_CREDIT'){
                    $this->displayMessage($comments);
                } else {
                    return true;
                }
        } else {
            $this->displayMessage('Transaction mapping failed');
        }
    }

    /**
     * Insert transaction details
     *
     * @param       $transaction_details
     * @return      none
     */
    public function insertTransactionDetails($transaction_details) {
        $transaction_details['payment_configurations'] = "'" . json_encode($this->model_extension_payment_novalnet->getMerchantDetails()) . "'";
        $columns = $values = array();
        foreach($transaction_details as $key => $value){
            $columns[] = $key;
            $values[] = $value;
        }
        $this->model_extension_payment_novalnet->dbInsert('novalnet_transactions', $columns, $values);
    }

    /**
     * Get payment key
     *
     * @param       $payment_type
     * @return      integer
     */
    public function getPaymentKey($payment_type)
    {
        $payment_key = array(
            'novalnet_instant_bank_transfer' => 33,
            'novalnet_ideal' => 49,
            'novalnet_paypal' => 34,
            'novalnet_eps' => 50,
            'novalnet_cc' => 6,
            'novalnet_przelewy24' => 78,
            'novalnet_sepa' => 37,
            'novalnet_invoice' => 27,
            'novalnet_prepayment' => 27,
            'novalnet_giropay' => 69,
            'novalnet_cashpayment' => 59,
        );
        return ($payment_key[$payment_type]);
    }

    /**
     * validate request parameters
     *
     * @param       none
     * @return      none
     */
    public function validateCaptureParameters()
    {
        foreach ($this->required_params as $value) {
            if (empty($this->capture_params[$value])) {
                $this->displayMessage('Required param(' . $value . ') missing!');
            } else if (in_array($value, array(
                    'tid',
                    'tid_payment',
                    'signup_tid'
                )) && !preg_match('/^\d{17}$/', $this->capture_params[$value])) {
                $this->displayMessage('Novalnet callback received. Invalid TID [' . $this->capture_params[$value] . '] for Order.');
            }
        }
        if (!in_array($this->capture_params['payment_type'], array_merge($this->collections, $this->chargebacks, $this->payments, $this->subscriptions, array('TRANSACTION_CANCELLATION') ))) {
            $this->displayMessage('Novalnet callback received. Payment type [' . $this->capture_params['payment_type'] . '] is mismatched!');
        }
    }

    /**
     * Update callback comments in order_history table
     *
     * @param       $data
     * @return      none
     */
    public function updateCallbackComments($data)
    {
        $comments            = ($data['comments'] != '') ? $data['comments'] : '';
        $this->model_extension_payment_novalnet->dbInsert('order_history', array(
            'comment',
            'order_status_id',
            'order_id',
            'notify',
            'date_added'
        ), array(
            "'" . $this->db->escape($comments) . "'",
            $this->db->escape($data['orders_status_id']),
            $this->db->escape($data['order_no']),
            1,
            "'" . date('Y-m-d h:i:s') . "'"
        ));
    }
    
    /**
     * Transaction cancellation.
     * 
     * @param       none
     * @return      none
     */
    public function transaction_cancellation(){
        // Get Transaction details.
        $selected_details = $this->model_extension_payment_novalnet->dbSelect('novalnet_transactions', 'gateway_status', 'tid =' . $this->capture_params['shop_tid']);

        if ( 'TRANSACTION_CANCELLATION' === $this->capture_params ['payment_type'] && in_array( $selected_details['gateway_status'], array('75','91','99','98','85', '90', '86' )) || (in_array( $this->capture_params['payment_type'], array('GUARANTEED_INVOICE', 'GUARANTEED_DIRECT_DEBIT_SEPA' )) && $this->capture_params ['tid_status'] == '103' && in_array( $selected_details['gateway_status'], array('75','91','99','98','85', '90', '86' )))) {
            $novalnet_comments ='The transaction has been canceled on ' .date('Y-m-d H:i:s') . '.';
            // Update order status ID in shop order table.
            $this->model_extension_payment_novalnet->dbUpdate('order', array(
                'order_status_id' => $this->config->get('payment_novalnet_cancel_status'),
            ),  'order_id=' . $this->transaction_history['order_no']);
            // Update Transaction status for the order in Novalnet table.
            $this->model_extension_payment_novalnet->dbUpdate('novalnet_transactions', array(
                'gateway_status' => $this->capture_params['tid_status']
            ),  'order_no=' . $this->transaction_history['order_no']); 
            // Update callback comments.
            $this->updateCallbackComments(array(
            'order_no' => $this->transaction_history['order_no'],
            'comments' => $novalnet_comments,
            'orders_status_id' => $this->config->get('payment_novalnet_cancel_status')
            ));
            $this->displayMessage( $novalnet_comments );
        }
    }

    /**
     * Send notification mail to merchant
     *
     * @param       $callback_comments
     * @return      none
     */
    public function sendNotificationMail($callback_comments)
    {
        if ($this->config->get('payment_novalnet_callback_mail') == 'yes') {
            $email_from_name = $this->config->get('config_email');
            $email_to         = (($this->config->get('payment_novalnet_callback_to_addr') != '') ? $this->config->get('payment_novalnet_callback_to_addr') : $email_from_name);
            $email_subject    = 'Novalnet Callback script notification ';
            $email_content    = $callback_comments;
            $email_content    = str_replace('<br>', ' ', $email_content);
            $email_content    = str_replace('<b>', ' ', $email_content);
            $email_content    = str_replace('</b>', ' ', $email_content);
            $email_content    = str_replace('</br>', ' ', $email_content);
            $email_content    = str_replace('<br/>', ' ', $email_content);
            // Send Callback notification E-mail.
            if (preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email_to)) {
                $mail = new Mail();
                $mail_bcc_addr = $this->config->get('payment_novalnet_callback_bcc_addr');
                if(!empty($mail_bcc_addr)){
                    $bcc_address = explode(',', $this->config->get('payment_novalnet_callback_bcc_addr'));
                    foreach($bcc_address as $email_bcc) {
                        $mail->parameter .= 'Bcc: <' . $email_bcc . '>' . PHP_EOL;
                    }
                }
                $mail->setTo($email_to);
                $mail->setFrom($email_from_name);
                $mail->setSender($email_from_name);
                $mail->setSubject($email_subject);
                $mail->setText($email_content);
                $mail->send();
            }
        }
    }
    
    /**
     * Send critical error mail.
     *
     * @param  none
     * @return none
     */
    public function send_critical_error_mail()
    {
        if ( $this->capture_params ['status'] == '100' ) {
            $email_from_name = $this->config->get('config_email');
            $email_subject = 'Critical error on shop system ' . $this->config->get('config_template') . ': order not found for TID: ' . $this->capture_params ['shop_tid'];
            // Define some variables to assign to template
            $comments = 'Technic team,'.PHP_EOL . PHP_EOL.'Please evaluate this transaction and contact our Technic team and Backend team at Novalnet.' . PHP_EOL . PHP_EOL;
            $comments .= 'Merchant ID: ' . $this->capture_params['vendor_id'] . PHP_EOL;
            $comments .= 'Project ID: ' . $this->capture_params['product_id'] . PHP_EOL;
            $comments .= 'TID: ' . $this->capture_params['shop_tid'] . PHP_EOL;
            $comments .= 'TID status: ' . $this->capture_params['tid_status'] . PHP_EOL;
            $comments .= 'Order no: ' . $this->capture_params['order_no'] . PHP_EOL;
            $comments .= 'Payment type: ' . $this->capture_params['payment_type'] . PHP_EOL;
            $comments .= 'E-mail: ' . $this->capture_params['email'] . PHP_EOL . PHP_EOL . PHP_EOL;
            $comments .= 'Regards,'.PHP_EOL.'Novalnet Team';
            $mail = new Mail();
            $mail->setTo('technic@novalnet.de');
            $mail->setFrom($email_from_name);
            $mail->setSender($email_from_name);
            $mail->setSubject($email_subject);
            $mail->setText($comments);
            $mail->send();
        }
    }

    /**
     * Validate IP address
     *
     * @param       none
     * @return      none
     */
    public function validateIpAddress()
    {
        $real_host_ip = gethostbyname('pay-nn.de');
        if (empty($real_host_ip)) {
            $this->displayMessage('Novalnet HOST IP missing');
        }
        $client_ip = $_SERVER['REMOTE_ADDR'];
        if ($client_ip != $real_host_ip && $this->test_mode != 'yes') {
            $this->displayMessage('Novalnet callback received. Unauthorised access from the IP ' . $client_ip);
        }
    }

    /**
     * Display the error message
     *
     * @param       $message
     * @return      none
     */
    public function displayMessage($message)
    {
        echo utf8_decode($message);
        exit;
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
            $email_from_name  = $this->config->get('config_email');
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
                $mail->setFrom($email_from_name);
                $mail->setSender($email_from_name);
                $mail->setSubject($email_subject);
                $mail->setHtml($email_content);
                $mail->send();
            }
        } else {
            $this->displayMessage(['message' =>'Mail not sent.']);
        }       
    }
}
