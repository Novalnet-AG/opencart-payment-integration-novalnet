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
 *
 */

class ModelExtensionPaymentNovalnet extends model
{
    var $payment_details = array(
        'novalnet_cc' => array(
            'key' => '6',
            'payment_type' => 'CREDITCARD'
        ),
        'novalnet_sepa' => array(
            'key' => '37',
            'payment_type' => 'DIRECT_DEBIT_SEPA'
        ),
        'novalnet_instant_bank_transfer' => array(
            'key' => '33',
            'payment_type' => 'ONLINE_TRANSFER'
        ),
        'novalnet_paypal' => array(
            'key' => '34',
            'payment_type' => 'PAYPAL'
        ),
        'novalnet_ideal' => array(
            'key' => '49',
            'payment_type' => 'IDEAL'
        ),
        'novalnet_eps' => array(
            'key' => '50',
            'payment_type' => 'EPS'
        ),
        'novalnet_giropay' => array(
            'key' => '69',
            'payment_type' => 'GIROPAY'
        ),
        'novalnet_invoice' => array(
            'key' => '27',
            'payment_type' => 'INVOICE'
        ),
        'novalnet_prepayment' => array(
            'key' => '27',
            'payment_type' => 'PREPAYMENT'
        ),
        'novalnet_przelewy24' => array(
            'key' => '78',
            'payment_type' => 'PRZELEWY24'
        ),
        'novalnet_invoice_guarantee' => array(
            'key' => '41',
            'payment_type' => 'GUARANTEED_INVOICE',
        ),
        'novalnet_sepa_guarantee' => array(
            'key' => '40',
            'payment_type' => 'GUARANTEED_DIRECT_DEBIT_SEPA',
        ),
        'novalnet_cashpayment' => array(
            'key'          => '59',
            'payment_type' => 'CASHPAYMENT',
        ),
        'novalnet_online_bank_transfer'=>array(
            'key'          => '113',
            'payment_type' => 'ONLINE_BANK_TRANSFER',
        ),
    );

    /**
     * To display the payment in front end.
     *
     * @param  $address
     * @param  $total
     * @return none
     */
    public function getMethod($address, $total)
    {
        return array();
    }

    /**
     * Get payment method details
     *
     * @param  $address
     * @param  $total
     * @param  $payment_name
     * @return array
     */
    public function getOptionMethod($address, $total, $payment_name) {
        $configuration_status = $this->config->get('payment_'.$payment_name . '_status');
        $this->load->language('extension/payment/' . $payment_name);
        if ((trim($this->config->get('payment_novalnet_public_key')) == '' && $configuration_status)) {
            return false;
        }
        return $configuration_status;
    }

    /**
     * Unset payment session values before displaying payment
     *
     * @param  $payment_name
     * @return none
     */
    public function unsetBeforePaymentSession($payment_name) {
        if ($payment_name != 'payment_novalnet_sepa' && !empty($this->session->data['novalnet_sepa'])) {
            unset($this->session->data['novalnet_sepa']);
        } else if ($payment_name != 'payment_novalnet_invoice' && !empty($this->session->data['novalnet_invoice'])) {
            unset($this->session->data['novalnet_invoice']);
        }
    }

    /**
     * Validate allowed countries
     *
     * @param  $country
     * @return boolean
     */
    public function validateAllowedCountries($country)
    {
        return in_array($country, array(
            'AT',
            'DE',
            'CH'
        ));
    }
    
    /**
     * Get merchant details
     *
     * @return array
     */
    public function getMerchantDetails() {

        // Get tariff type and value.
        $vendor_parameters = array(
            'vendor' => trim($this->config->get('payment_novalnet_merchant_id')),
            'product' => trim($this->config->get('payment_novalnet_project_id')),
            'tariff' => $this->getTariffId(),
            'auth_code' => trim($this->config->get('payment_novalnet_authcode')),
        );
        $this->session->data['nn']['payment_access_key'] = trim($this->config->get('payment_novalnet_access_key'));

        return $vendor_parameters;
    }

    /**
     * Get Tariff details
     *
     * @param  $get_tariff_type
     * @return integer
     */
    public function getTariffId($get_tariff_type = false) {
        $tariff_id = explode('-', $this->config->get('payment_novalnet_tariff_id'));
        return ($get_tariff_type) ? $tariff_id['1'] : $tariff_id['0'];
    }

    /**
     * Get Customer parameters
     *
     * @param  $order_info
     * @return array
     */
    public function getCustomerParameters($order_info) {
        $first_name = trim($order_info['payment_firstname']);
        $last_name  = trim($order_info['payment_lastname']);

        // Check for first name and lastname
        if (in_array('', array($first_name, $last_name))) {
            $name = $first_name . $last_name;
            list($first_name, $last_name) = (preg_match('/\s/', $name)) ? explode(' ', $name, 2) : array($name, $name);
        }
        return array(
            'gender'           => 'u',
            'first_name'       => $first_name,
            'last_name'        => $last_name,
            'email'            => trim($order_info['email']),
            'street'           => (!empty($order_info['payment_address_2'])) ? $order_info['payment_address_1'] . ', ' . $order_info['payment_address_2'] : $order_info['payment_address_1'],
            'search_in_street' => 1,
            'city'             => $order_info['payment_city'],
            'zip'              => $order_info['payment_postcode'],
            'tel'              => trim($order_info['telephone']),
            'country'          => $order_info['payment_iso_code_2'],
            'country_code'     => $order_info['payment_iso_code_2'],
            'customer_no'      => !empty($order_info['customer_id']) && ($order_info['customer_id'] > 0) ? $order_info['customer_id'] : 'guest',
        );
    }

    /**
     * Get Payment parameters
     *
     * @param  $payment_name
     * @param  $order_info
     * @return array
     */
    public function getParameters($payment_name, $order_info = '') {

        // Get order details.
        if(empty($order_info)) {
            $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        }
        $language   = $this->getLanguageCode($order_info['language_code']);

        // Form Vendor parameters.
        $vendor_parameters = $this->getMerchantDetails();

        // Form Customer parameters.
        $customer_parameters = $this->getCustomerParameters($order_info);
        $payment_key = $this->session->data['nn_payment_key'] = $this->payment_details[$payment_name]['key'];

        // Form order parameters.
        $order_parameters = array(
            'currency' => $order_info['currency_code'],
            'amount'   => $this->getAmountFormat($order_info['total'], $order_info['currency_value']),
            'order_no' => $order_info['order_id'],
            'lang' => $language,
            'language' => $language,
            'key' => $payment_key,
            'test_mode' => ($this->config->get('payment_'.$payment_name . '_testmode')),
            'payment_type' => $this->payment_details[$payment_name]['payment_type'],
        );

        // Form System parameters.
        $system_parameters = array(
            'remote_ip'      => $this->getIpAddress('REMOTE_ADDR'),
            'system_name'    => 'opencart',
            'system_version' => VERSION . '-' . 'NN_11.5.0',
            'system_url'     => ($this->request->server['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER,
            'system_ip'      => $this->getIpAddress('SERVER_ADDR')
        );

        // Form Additional parametrs.
        $additional_parameters = array_filter(array(
            'company'     => trim($order_info['payment_company']),
            'notify_url'  => trim($this->config->get('payment_novalnet_notification_url')),
            'input3'      => 'session_name',
            'inputval3'   => $this->config->get('session_name'),
            'input4'      => 'session_id',
            'inputval4'   => $this->session->getId(),
        ));

        return array_merge($vendor_parameters, $customer_parameters, $order_parameters, $system_parameters, $additional_parameters);
    }

    /**
     * Generate random unique id
     *
     * @param  none
     * @return string
     */
    function novalnet_get_random_string() {
        $randomwordarray = explode(',', '8,7,6,5,4,3,2,1,9,0,9,7,6,1,2,3,4,5,6,7,8,9,0');
        shuffle($randomwordarray);
        return substr(implode( '', $randomwordarray ), 0, 16);
    }

    /**
     * Get Redirect parameters
     *
     * @param  $parameters
     * @param  $payment_name
     * @return array
     */

    public function getRedirectParameters($parameters, $payment_name){
        $this->return_url   = $this->url->link('extension/payment/' . $payment_name . '/callback', '', true);
        $parameters['uniqid']   = $this->novalnet_get_random_string();
        $this->encode($parameters, array(
            'auth_code',
            'product',
            'tariff',
            'amount',
            'test_mode',
            ));
        $parameters['hash'] = $this->generateHashValue($parameters);
        $parameters = $this->getReturnUrl($parameters);
        return $parameters;
    }

    /**
     * Perform redirect payment post process
     *
     * @param  $url
     * @param  $parameters
     * @param  $payment_name
     * @return array
     */
    public function performRedirectProcess($url, $parameters, $payment_name)
    {
        $this->language->load('extension/payment/' . $payment_name);
        $json['data_redirect'] = '<form id="formnovalnet" name="formnovalnet" method="post" action="' . $url . '" >';
        foreach ($parameters as $key => $value) {
            $json['data_redirect'] .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
        }
        $json['data_redirect'] .= '<input type="submit" class="btn btn-primary" id="nn_btn_wait" name="enter" value="' . $this->language->get('text_loading') . '" disabled/></form><script>document.forms.formnovalnet.submit(); </script>';
        return $json;
    }

    /**
     * Perform redirect payment process
     *
     * @param  $payment_name
     * @return array
     */
    public function checkRedirectPaymentProcess($payment_name) {
        $server_response                 = $this->request->request;

        if (empty($this->session->data['nn'])) {

            $session_name = ($server_response['inputval3'] ? $server_response['inputval3'] : ($server_response['session_name'] ? $server_response['session_name'] : ''));

            $session_id = ($server_response['inputval4'] ? $server_response['inputval4'] : ($server_response['session_id'] ? $server_response['session_id'] : ''));

            $this->session->start($session_id);
            setcookie($session_name, $session_id, ini_get('session.cookie_lifetime'), ini_get('session.cookie_path'), ini_get('session.cookie_domain'));
        }

        if ($server_response['status'] == '100' ) {
            if($this->checkHashFailed($server_response)) {
                return array(
                    'type' => 'failure',
                    'error' => $this->language->get('error_check_hash'),
                );
            }
            $this->decode($server_response);
            return $server_response;
        }
        return array(
            'type' => 'failure',
            'error' => $this->setResponseMessage($server_response),
        );
    }

    /**
     * To check both request and response hash value
     *
     * @param  $server_response
     * @return boolean
     */
    public function checkHashFailed($server_response)
    {
        return (empty($server_response['hash2']) || $server_response['hash2'] != $this->generateHashValue($server_response));
    }

    /**
     * To encode the given data
     *
     * @param  $data
     * @param  $encoded_params
     * @return none
     */
    public function encode(&$data, $encoded_params) {

        foreach ($encoded_params as $value) {
            $encoded_data = $data[$value];
            $encode_data=   htmlentities(
                base64_encode(
              openssl_encrypt($encoded_data, "aes-256-cbc", $this->session->data['nn']['payment_access_key'], true, $data['uniqid'])
                )
            );
            $data[$value] = $encode_data;
        }
    }

    /**
     * To decode the given data
     *
     * @param  $data
     * @return string
     */
    public function decode(&$data) {
        $decode_params = array('product', 'tariff', 'test_mode', 'amount', 'auth_code');

        foreach ($decode_params as $param) {
            try {
              if (isset($data[$param])) {
                        $data[$param] = $this->novalnet_decrypt($data[$param], $data['uniqid'], $this->session->data['nn']['payment_access_key']);
                    }
            }
            catch (Exception $e) {

              return FALSE;
            }
        }
    }

    /**
     * To decode the given data
     *
     * @param  $data
     * @param  $uniqid
     * @param  $key
     * @return string
     */
    public function novalnet_decrypt($data, $uniqid, $key) {
        // Return decrypted Data.
         $decript=openssl_decrypt(
            base64_decode($data),
                "aes-256-cbc", $key, true, $uniqid
        );
        return $decript;
    }

    /**
     * To generate hash value
     *
     * @param       $data
     * @return      string
     */
    public function generateHashValue($data) {
        $key=$this->session->data['nn']['payment_access_key'];
        $hash = '';
       foreach (array('auth_code', 'product', 'tariff', 'amount', 'test_mode', 'uniqid') as $params) {

       $hash .= $data[$params];

       }
        $hash .= strrev($key);

        return hash('sha256', $hash);
    }

    /**
     * Get return url parameters
     *
     * @param       $parameters
     * @return      none
     */
    public function getReturnUrl($parameters)
    {
        $parameters['return_url']      = $parameters['error_return_url'] = $this->return_url;
        $parameters['return_method']   = $parameters['error_return_method'] = 'POST';
        $parameters['implementation']  = 'ENC';
        $parameters['user_variable_0'] = ($this->request->server['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER;
        return $parameters;
    }

    /**
     * Handle susbscription process for Opencart (version > 3.0.0.0)
     *
     * @param       $response
     * @param       $order_info
     * @param       $transaction_comments
     * @return      none
     */
    public function handleSubscriptionProcess($response, $order_info, $transaction_comments) {

        $recurring_products = $this->cart->getRecurringProducts();
        $this->load->model('checkout/recurring');
        $this->load->model('account/recurring');
        foreach($recurring_products as $recurring_product ) {
            // Get trial details.
            $subscription_trial_details = '';
            $recurring_product['recurring']['product_id'] = $recurring_product['product_id'];
            $recurring_product['recurring']['quantity'] = $recurring_product['quantity'];


            //trial information
            if ($recurring_product['recurring']['trial'] == 1) {
                $trial_amt = $this->currency->format($this->tax->calculate($recurring_product['recurring']['trial_price'], $recurring_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], false, false) * $recurring_product['quantity'] . ' ' . $this->session->data['currency'];
                $trial_text =  sprintf($this->language->get('text_trial'), $trial_amt, $recurring_product['recurring']['trial_cycle'], $recurring_product['recurring']['trial_frequency'], $recurring_product['recurring']['trial_duration']);

            } else {
                $trial_text = '';
            }
            $recurring_amt = $this->currency->format($this->tax->calculate($recurring_product['recurring']['price'], $recurring_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], false, false)  * $recurring_product['quantity'] . ' ' . $this->session->data['currency'];

            $recurring_description = $trial_text . sprintf($this->language->get('text_recurring'), $recurring_amt, $recurring_product['recurring']['cycle'], $recurring_product['recurring']['frequency']);

            if ($recurring_product['recurring']['duration'] > 0) {
                $recurring_description .= sprintf($this->language->get('text_length'), $recurring_product['recurring']['duration']);
            }
            $recurring_id = $this->model_checkout_recurring->addRecurring($order_info['order_id'], $recurring_description, $recurring_product);
            $next_payment     = new DateTime('now');
            $trial_end        = new DateTime('now');
            $recurring_end = new DateTime('now');
            list($next_payment, $trial_end, $recurring_end) = $this->calculatePaymentDate($recurring_product, $next_payment, $trial_end, $recurring_end);
            $subscription_recurring_details = json_encode(array(
                'recurring_frequency'    => $recurring_product['recurring']['frequency'],
                'recurring_duration'     => $recurring_product['recurring']['duration'],
                'recurring_cycle'        => $recurring_product['recurring']['cycle'],
                'recurring_price'        => $this->getAmountFormat($recurring_product['recurring']['price']),
                'recurring_period_end'      => date_format($recurring_end, 'Y-m-d'),
            ));

            // Check for trial details.
            if($recurring_product['recurring']['trial']) {
                $subscription_trial_details = json_encode(array(
                    'trial_frequency'  => $recurring_product['recurring']['trial_frequency'],
                    'trial_duration'   => $recurring_product['recurring']['trial_duration'],
                    'trial_cycle'      => $recurring_product['recurring']['trial_cycle'],
                    'trial_price'      => $this->getAmountFormat($recurring_product['recurring']['trial_price']),
                    'trial_period_end'      => date_format($trial_end, 'Y-m-d'),
                ));
            }
            $this->model_checkout_recurring->editReference($recurring_id, $response['tid']);
            $recurring = $this->getNovalnetOrderRecurringStatus($recurring_id);
            if ($recurring['status'] != '1') {
                $this->model_account_recurring->editOrderRecurringStatus($recurring_id, '1');
            }
            $this->storeNovalnetSubscriptions(array(
                'order_no'             => $order_info['order_id'],
                'order_recurring_id '  => $recurring_id,
                'tid'                  => $response['tid'],
                'next_subs_cycle'      => date_format($next_payment, 'Y-m-d'),
                'trial_details'        => $subscription_trial_details,
                'recurring_details'    => $subscription_recurring_details,
                'additional_details'   => json_encode($recurring_products),
            ));
            $amount = ($order_info['payment_code'] == 'novalnet_paypal') ? $response['amount']/100 : $response['amount'];
            $this->storeNovalnetRecurring(array(
				'order_no' 				=> $order_info['order_id'],
				'order_recurring_id' 	=> $recurring_id,
				'tid' 					=> $response['tid'],
				'amount' 				=> $this->currency->format($amount, $order_info['currency_code'],1),
				'payment_type' 			=> $order_info['payment_code'],
				'transaction_details' 	=> $transaction_comments,
				'status' 				=> ($response['tid_status'] == '100') ? 'paid' : 'unpaid',
				'date_added' 			=> date("Y-m-d H:i:s")
            ));
        }
    }

    /**
     * Handle susbscription process for Opencart version 3.0.0.0
     *
     * @param       $response
     * @param       $order_info
     * @param       $transaction_comments
     * @return      none
     */

    public function handleOldSubscriptionProcess($response, $order_info, $transaction_comments) {
        $recurring_products = $this->cart->getRecurringProducts();
        $this->load->model('checkout/recurring');
        $this->load->model('account/recurring');
        foreach($recurring_products as $recurring_product ) {
            // Get trial details.
            $subscription_trial_details = '';
            $recurring_id     = $this->model_checkout_recurring->create($recurring_product, $order_info['order_id'], $transaction_comments);
            $next_payment     = new DateTime('now');
            $trial_end        = new DateTime('now');
            $recurring_end = new DateTime('now');
            list($next_payment, $trial_end, $recurring_end) = $this->calculatePaymentDate($recurring_product, $next_payment, $trial_end, $recurring_end);
            $subscription_recurring_details = json_encode(array(
                'recurring_frequency'    => $recurring_product['recurring']['frequency'],
                'recurring_duration'     => $recurring_product['recurring']['duration'],
                'recurring_cycle'        => $recurring_product['recurring']['cycle'],
                'recurring_price'        => $this->getAmountFormat($recurring_product['recurring']['price']),
                'recurring_period_end'      => date_format($recurring_end, 'Y-m-d'),
            ));
            // Check for trial details.
            if($recurring_product['recurring']['trial']) {
                $subscription_trial_details = json_encode(array(
                    'trial_frequency'  => $recurring_product['recurring']['trial_frequency'],
                    'trial_duration'   => $recurring_product['recurring']['trial_duration'],
                    'trial_cycle'      => $recurring_product['recurring']['trial_cycle'],
                    'trial_price'      => $this->getAmountFormat($recurring_product['recurring']['trial_price']),
                    'trial_period_end'      => date_format($trial_end, 'Y-m-d'),
                ));
            }
            $this->model_checkout_recurring->addReference($recurring_id, $response['tid']);
            $recurring = $this->getNovalnetOrderRecurringStatus($recurring_id);
            if ($recurring['status'] != '1') {
                $this->model_account_recurring->editOrderRecurringStatus($recurring_id, '1');
            }
            $this->storeNovalnetSubscriptions(array(
                'order_no'             => $order_info['order_id'],
                'order_recurring_id '  => $recurring_id,
                'tid'                  => $response['tid'],
                'next_subs_cycle'      => date_format($next_payment, 'Y-m-d'),
                'trial_details'        => $subscription_trial_details,
                'recurring_details'    => $subscription_recurring_details,
                'additional_details'   => json_encode($recurring_products),
            ));
        }
    }

    /**
     * Return recurring order status
     *
     * @param       $order_recurring_id
     * @return      array
     */
    public function getNovalnetOrderRecurringStatus($order_recurring_id){
        return $this->dbSelect('order_recurring', 'status', 'order_recurring_id=' . $order_recurring_id);
    }

    /**
     * Calculate payment date
     *
     * @param       $recurring_product
     * @param       $next_payment
     * @param       $trial_end
     * @param       $recurring_end
     * @return      array
     */
    public function calculatePaymentDate($recurring_product, $next_payment, $trial_end, $recurring_end) {

        if ($recurring_product['recurring']['trial'] == 1 && $recurring_product['recurring']['trial_duration'] != 0) {
                $next_payment = $this->calculateSubscriptionSchedule($recurring_product['recurring']['trial_frequency'], $next_payment, $recurring_product['recurring']['trial_cycle']);

                $trial_end    = $this->calculateSubscriptionSchedule($recurring_product['recurring']['trial_frequency'], $trial_end, $recurring_product['recurring']['trial_cycle'] * $recurring_product['recurring']['trial_duration']);

        } elseif ($recurring_product['recurring']['trial'] == 1) {
            $next_payment = $this->calculateSubscriptionSchedule($recurring_product['recurring']['trial_frequency'], $next_payment, $recurring_product['recurring']['trial_cycle']);
            $trial_end    = new DateTime('0000-00-00');
        }

        if ($trial_end > $recurring_end && $recurring_product['recurring']['duration'] != 0) {
            $recurring_end = new DateTime(date_format($trial_end, 'Y-m-d H:i:s'));
            $recurring_end = $this->calculateSubscriptionSchedule($recurring_product['recurring']['frequency'], $recurring_end, $recurring_product['recurring']['cycle'] * $recurring_product['recurring']['duration']);
        } elseif ($trial_end == $recurring_end && $recurring_product['recurring']['duration'] != 0) {
            $next_payment     = $this->calculateSubscriptionSchedule($recurring_product['recurring']['frequency'], $next_payment, $recurring_product['recurring']['cycle']);

            $recurring_end = $this->calculateSubscriptionSchedule($recurring_product['recurring']['frequency'], $recurring_end, $recurring_product['recurring']['cycle'] * $recurring_product['recurring']['duration']);
        } elseif ($trial_end > $recurring_end && $recurring_product['recurring']['duration'] == 0) {
            $recurring_end = new DateTime('0000-00-00');
        } elseif ($trial_end == $recurring_end && $recurring_product['recurring']['duration'] == 0) {
            $next_payment     = $this->calculateSubscriptionSchedule($recurring_product['recurring']['frequency'], $next_payment, $recurring_product['recurring']['cycle']);

            $recurring_end = new DateTime('0000-00-00');
        }
        return array($next_payment, $trial_end, $recurring_end);
    }

    /**
     * Perform Novalnet success transaction process
     *
     * @param  $response
     * @param  $payment_name
     * @return array
     */
    public function transactionSuccess($response, $payment_name) {
        $payment_type = $payment_name;
        $payment_name = 'payment_'.$payment_name;
        $this->load->model('checkout/order');
        // Get order data.
        $order_info         = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        // Prepare transaction comments.
        $transaction_comments = $this->prepareTransactionComments($response, $payment_type);

        // Handle subscription process.
        if(VERSION == '3.0.0.0') {
            $this->handleOldSubscriptionProcess($response, $order_info, $transaction_comments);
        }
        else {
            $this->handleSubscriptionProcess($response, $order_info, $transaction_comments);
        }
        // Get amount in cents.
        $formated_amount             = $this->getAmountFormat($order_info['total'], $order_info['currency_value']);

        $pending_payment = in_array($response['tid_status'], array('86', '90'));

        $invoice_payment = in_array($payment_type, array('novalnet_invoice', 'novalnet_prepayment', 'novalnet_cashpayment'));

        // Get order status.
        if (in_array($response['payment_id'], array('40', '41')) && $response['tid_status'] == '75') {
            $order_status = $this->config->get($payment_name . '_guarantee_pending_order_status');
        } else if(in_array($response['tid_status'], array('86', '90'))) {
            $order_status  = $this->config->get($payment_name . '_pending_order_status');
        }else if( in_array($response['tid_status'], array('85', '91', '98', '99')) ) {
            $order_status  = $this->config->get('payment_novalnet_onhold_complete_status');
        } else {
             $order_status  = $this->config->get($payment_name . '_order_completion_status');
        }

        $configuration_details = $this->getMerchantDetails();

        // Insert transaction details
        $this->storeNovalnetTransactions(array(
            'order_no'               => $order_info['order_id'],
            'tid'                    => $response['tid'],
            'gateway_status'         => $response['tid_status'],
            'payment_type'           => $payment_type,
            'payment_id'             => $this->session->data['nn_payment_key'],
            'customer_id'            => $order_info['customer_id'],
            'create_payment_ref'     => (int) !empty($response['create_payment_ref']) && $this->config->get($payment_name.'_shopping_type') == 'ONE_CLICK' ? 1 : 0,
            'payment_configurations' => json_encode(array(
                'vendor'    => $configuration_details['vendor'],
                'product'   => $configuration_details['product'],
                'tariff'    => $configuration_details['tariff'],
                'auth_code' => $configuration_details['auth_code'],
                'test_mode' => (int) ((!empty($response['test_mode']) && $response['test_mode']) || ($this->config->get($payment_name . '_testmode') == '1')),
            )),
            'transaction_details' => json_encode(array(
                'amount'        => ($this->config->get($payment_name.'_shopping_type') == 'ZERO_AMOUNT' && $this->getTariffId(true) == '2') ? 0 : $formated_amount,
                'total_amount'  => $formated_amount,
                'refund_amount' => 0,
                'currency'      => $order_info['currency_code'],
                'reference_tid' => !empty($this->session->data[$payment_name . '_reference_tid']) ? $this->session->data[$payment_name . '_reference_tid'] : 'NULL',
            )),
            'one_click_details'   => !empty($response['one_click_details']) ? $response['one_click_details'] : '',
            'zero_amount_details' => (($this->config->get($payment_name.'_shopping_type') == 'ZERO_AMOUNT' && $this->getTariffId(true) == '2') && (!in_array($response['payment_id'], array('40', '41')) && $response['tid_status'] != '75')) ? addslashes(json_encode($this->session->data[$payment_type]['payment_params'])) : 0,
            'additional_details'  => !empty($response['additional_details']) ? addslashes($response['additional_details']) : '',
        ));
        // Insert callback details.
        $this->storeMerchantScriptDetails(array(
            'order_no'     => $order_info['order_id'],
            'original_tid' => $response['tid'],
            'callback_tid' => $response['tid'],
            'payment_type' => $payment_type,
            'amount'       => ($invoice_payment || $pending_payment) ? 0 : $formated_amount,
        ));
        // Unset Novalnet sessions.
        $this->unsetSessionValues($payment_type);
        return array(
            'orderStatus'       => $order_status,
            'novalnet_comments' => $transaction_comments,
            'order_info'        => $order_info,
        );
    }

    /**
     * Insert details into the Novalnet transactions table
     *
     * @param  $transaction_details
     * @return none
     */
    public function storeNovalnetTransactions($transaction_details) {
        foreach ($transaction_details as $key => $value) {
            $transaction_details[$key] = "'" . $transaction_details[$key] . "'";
        }
        $transaction_details['date']         = "'" . date('Y-m-d H:i:s') . "'";
        $this->dbInsert('novalnet_transactions', array_keys($transaction_details), $transaction_details);
    }

    /**
     * Insert details into the Novalnet subscriptions table
     *
     * @param  $subscription_details
     * @return none
     */
    public function storeNovalnetSubscriptions($subscription_details) {

        foreach ($subscription_details as $key => $value) {
            $subscription_details[$key] = "'" . $subscription_details[$key] . "'";
        }
        $this->dbInsert('novalnet_subscriptions', array_keys($subscription_details), $subscription_details);
    }
    
    /**
     * Insert details into the Novalnet recurring table
     *
     * @param  $recurring_details
     * @return none
     */
    public function storeNovalnetRecurring($recurring_details) {

        foreach ($recurring_details as $key => $value) {
            $recurring_details[$key] = "'" . $recurring_details[$key] . "'";
        }
        $this->dbInsert('novalnet_recurring_transactions', array_keys($recurring_details), $recurring_details);
    }

    /**
     * Insert and Update shop information into the database
     *
     * @param   $merchant_script_details
     * @return  none
     */
    public function storeMerchantScriptDetails($merchant_script_details)
    {
        foreach ($merchant_script_details as $key => $value) {
            $merchant_script_details[$key] = "'" . $merchant_script_details[$key] . "'";
        }
        $merchant_script_details['date']         = "'" . date('Y-m-d H:i:s') . "'";
        $this->dbInsert('novalnet_merchant_script', array_keys($merchant_script_details), $merchant_script_details);
    }

    /**
     * Unset payment session values after order completion
     *
     * @param      $payment_name
     * @return      none
     */
    public function unsetSessionValues($payment_name)
    {
        if (!empty($this->session->data[$payment_name])) {
            unset($this->session->data[$payment_name]);
        }
        if (!empty($this->session->data[$payment_name . '_payment_parameters'])) {
            unset($this->session->data[$payment_name . '_payment_parameters']);
        }
        if (!empty($this->session->data['nn_payment_key'])) {
            unset($this->session->data['nn_payment_key']);
        }
        if (!empty($this->session->data['new_or_placed_payment_details'])) {
            unset($this->session->data['new_or_placed_payment_details']);
        }
        if (!empty($this->session->data['nn']['payment_access_key'])) {
            unset($this->session->data['nn']['payment_access_key']);
        }
        if (!empty($this->session->data[$payment_name . '_reference_tid'])) {
            unset($this->session->data[$payment_name . '_reference_tid']);
        }
    }

    /**
     * Insert values into the database
     *
     * @param       $table_name
     * @param       $insert_columns
     * @param       $insert_values
     * @return      none
     */
    public function dbInsert($table_name, $insert_columns, $insert_values) {
        $get_columns = implode(',', $insert_columns);
        $get_values = implode(',', $insert_values);
        $this->db->query("INSERT INTO " . DB_PREFIX . $table_name . "(" . $get_columns . ") values (" . $get_values . ")");
    }

    /**
     * Select the database row values
     *
     * @param       $table_name
     * @param       $fields
     * @param       $conditions
     * @param       $check
     * @return      array
     */
    public function dbSelect($table_name, $fields, $conditions, $check=false)
    {
        $select_query = 'SELECT ' . $fields . ' FROM ' . DB_PREFIX . $table_name . ' WHERE ' . $conditions;
        $result       = $this->db->query($select_query);
        return ($check) ? $result->rows : $result->row;
    }

    /**
     * Update the values into the database
     *
     * @param       $table_name
     * @param       $fields
     * @param       $conditions
     * @return      none
     */
    public function dbUpdate($table_name, $fields, $conditions) {
        $get_fields = '';
        if (is_array($fields)) {
            foreach ($fields as $key => $value) {
                $get_fields .= $key . '=' . $value . ',';
            }
            $get_fields = substr($get_fields, 0, -1);
        } else {
            $get_fields = $fields;
        }
        $this->db->query("UPDATE " . DB_PREFIX . $table_name . " SET " . $get_fields . " WHERE " . $conditions);
    }

    /**
     * Prepare Novalnet transaction comments
     *
     * @param      $response
     * @param      $order_info
     * @param      $payment_name
     * @param      $order_id
     * @return      string
     */
    public function prepareNovalnetComments($response, $order_info, $callback = false)
    {
        $novalnet_comments  = '';
        $novalnet_comments .= $this->prepareBankDetailsComments($response, $order_info, $callback);
        return $novalnet_comments;
    }

    /**
     * Prepare Bank details comments
     *
     * @param  $response
     * @param  $order_info
     * @return string
     */
    public function prepareBankDetailsComments($response, $order_info, $callback = false)
    {
        $novalnet_comments = '<br><br>' . $this->language->get('text_novalnet_bank_comments') . '<br>';
        if($response['tid_status'] == '100' && !empty($response['due_date'])) {
			$novalnet_comments .= $this->language->get('text_novalnet_due_date') . date($this->language->get('date_format_short'), strtotime($response['due_date'])). '<br>';
		}
        $novalnet_comments .= $this->language->get('text_novalnet_account_holder') . $response['invoice_account_holder'] . '<br>';
        $novalnet_comments .= $this->language->get('text_novalnet_iban') . $response['invoice_iban'] . '<br>';
        $novalnet_comments .= $this->language->get('text_novalnet_bic') . $response['invoice_bic'] . '<br>';
        $novalnet_comments .= $this->language->get('text_novalnet_bank') . $response['invoice_bankname'] . ' ' . !empty($response['invoice_bankplace']) . '<br>';
        $amount = ($callback) ? $response['amount']/100 : $response['amount'];			
        $novalnet_comments .= $this->language->get('text_novalnet_amount') . $this->currency->format($amount, $order_info['currency_code'],1). '<br><br>';
        $novalnet_comments .= $this->language->get('text_payment_reference_any_one') . '<br>';
        $novalnet_comments .= $this->language->get('text_payment_reference') . ' 1: TID ' . $response['tid'] . '<br/>';
        $order_no = !empty($response['order_no']) ? $response['order_no'] : $order_info['order_id'];
        $novalnet_comments .= $this->language->get('text_payment_reference') . ' 2: BNR-' . trim($this->config->get('payment_novalnet_project_id')) . '-' . $order_no . '<br>';        
        return $novalnet_comments;
    }

    /**
     * Prepare Barzahlen Transaction comments.
     *
     * @param      $response
     * @return      string
     */
    function prepareBarzahlenComments($response) {
        $storeCounts = 0;
        foreach ($response as $key => $value) {
            if (strpos($key, 'nearest_store_street') === 0) {
                $storeCounts++;
            }
        }
        $novalnet_comments  = ($response['cp_due_date'] != '') ? '<br>' . $this->language->get('text_novalnet_slip_expiry_date') . date($this->language->get('date_format_short'), strtotime($response['cp_due_date'])) . '<br>' : '';
        $novalnet_comments .= '<br>' . $this->language->get('text_nearest_store_details'). '<br>';
        for($i=1; $i<=$storeCounts;$i++) {
            $novalnet_comments .= '<br>' . $response['nearest_store_title_' . $i];
            $novalnet_comments .= '<br>' . $response['nearest_store_street_' . $i];
            $novalnet_comments .= '<br>' . $response['nearest_store_city_' . $i];
            $novalnet_comments .= '<br>' . $response['nearest_store_zipcode_' . $i];
            $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "country WHERE iso_code_2 = '".$response['nearest_store_country_' . $i]."'");
            $novalnet_comments .= '<br>' . $query->row['name']. '<br>';
        }
        return $novalnet_comments;
    }

    /**
     * Prepare Transaction comments.
     *
     * @param      $response
     * @param      $payment_name
     * @return      string
     */
    public function prepareTransactionComments($response, $payment_name) {
        $payment_type = $payment_name;
        $payment_name = 'payment_'.$payment_name;
        $transaction_comments = '';
        if(isset($response['payment_id']) && in_array($response['payment_id'],array('40','41'))) {
            $transaction_comments .=  $this->language->get('text_guarantee_payment') . '<br/>' ;
        }
        $transaction_comments .= $this->language->get('text_' . $payment_type . '_title') . '<br>';
        $transaction_comments .= $this->language->get('text_novalnet_TID') . $response['tid'] . '<br>';
        $transaction_comments .= ($response['test_mode'] == 1 || $this->config->get($payment_name . '_testmode') == 1) ? $this->language->get('text_novalnet_test_order') : '';
        if(isset($response['payment_id']) && $response['payment_id'] == '41' && $response['tid_status'] == 75) {
            $transaction_comments .=  $this->language->get('text_guarantee_pending_text') . '<br/>' ;
        }
        if(isset($response['payment_id']) && $response['payment_id'] == '40' && $response['tid_status'] == 75) {
            $transaction_comments .=  $this->language->get('text_guarantee_pending_sepa_text') . '<br/>' ;
        }
        return $transaction_comments;
    }

    /**
     * Get Novalnet recurring profile
     *
     * @param       none
     * @return      array
     */
    public function getNovalnetRecurringProfiles() {
        $current_date = date('Y-m-d');       
        $sql             = "SELECT ore.order_recurring_id, o.order_status_id FROM " . DB_PREFIX . "order_recurring ore
        INNER JOIN " . DB_PREFIX . "order o ON o.order_id = ore.order_id
        INNER JOIN " . DB_PREFIX . "novalnet_subscriptions ns ON ns.order_no = o.order_id
        WHERE ( ns.order_recurring_id = ore.order_recurring_id) AND ( ns.next_subs_cycle = '" . $current_date . "') ORDER BY ore.order_recurring_id DESC";
        $qry             = $this->db->query($sql);
        $order_recurring = array();
        foreach ($qry->rows as $profile) {
            $order_recurring[] = $this->getProfile($profile['order_recurring_id']);
        }
        return $order_recurring;
    }

    /**
     * Get order recurring profile
     *
     * @param      $order_recurring_id
     * @return      array
     */
    public function getProfile($order_recurring_id) {
        $qry = $this->db->query("SELECT order_recurring_id, order_id, reference, product_id, product_name, product_quantity, recurring_id, recurring_name, recurring_description, recurring_frequency, recurring_cycle, recurring_duration, recurring_price, trial, trial_frequency, trial_cycle, trial_duration, trial_price, status, date_added FROM " . DB_PREFIX . "order_recurring WHERE order_recurring_id = " . (int)$order_recurring_id);
        return $qry->row;
    }

    /**
     * Get Novalnet recurring order details
     *
     * @param       $order_recurring_id
     * @return      array
     */
    public function getRecurringOrder($order_recurring_id) {
        $qry = $this->db->query("SELECT order_no, order_recurring_id, tid, next_subs_cycle, trial_details, recurring_details, additional_details, recurring_date_added FROM " . DB_PREFIX . "novalnet_subscriptions WHERE order_recurring_id = '" . (int)$order_recurring_id . "'");
        return $qry->row;
    }

    /**
     * Get Novalnet recurring reference details
     *
     * @param       $order_id
     * @return      array
     */
    public function getReferenceDetails($order_id) {
        $qry = $this->db->query("SELECT transaction_details FROM " . DB_PREFIX . "novalnet_transactions WHERE order_no = '" . (int)$order_id . "'");
        return $qry->row;
    }

    /**
     * Calculate subscription schedules
     *
     * @param      $frequency
     * @param      $next_payment
     * @param      $cycle
     * @return      object
     */
    public function calculateSubscriptionSchedule($frequency, $next_payment, $cycle) {
        if ($frequency == 'semi_month') {
            $day    = date_format($next_payment, 'd');
            $value  = 15 - $day;
            $is_even = false;
            if ($cycle % 2 == 0) {
                $is_even = true;
            }
            $odd        = ($cycle + 1) / 2;
            $plus_even  = ($cycle / 2) + 1;
            $minus_even = $cycle / 2;
            if ($day == 1) {
                $odd       = $odd - 1;
                $plus_even = $plus_even - 1;
                $day       = 16;
            }
            if ($day <= 15 && $is_even) {
                $next_payment->modify('+' . $value . ' day');
                $next_payment->modify('+' . $minus_even . ' month');
            } elseif ($day <= 15) {
                $next_payment->modify('first day of this month');
                $next_payment->modify('+' . $odd . ' month');
            } elseif ($day > 15 && $is_even) {
                $next_payment->modify('first day of this month');
                $next_payment->modify('+' . $plus_even . ' month');
            } elseif ($day > 15) {
                $next_payment->modify('+' . $value . ' day');
                $next_payment->modify('+' . $odd . ' month');
            }
        } else {
            $next_payment->modify('+' . $cycle . ' ' . $frequency);
        }
        return $next_payment;
    }

    /**
     * Get the recurring order details
     *
     * @param       $order_id
     * @return      string
     */
    public function getRecuringOrders($order_id) {
        return $this->db->query("SELECT order_recurring_transaction_id FROM " . DB_PREFIX . "order_recurring_transaction WHERE order_recurring_id = $order_id");
    }

    /**
     * Perform CURL process
     *
     * @param       $parameters
     * @param       $url
     * @param       $payment_call
     * @return      string
     */
    public function performPaymentCall($parameters, $url = 'https://payport.novalnet.de/paygate.jsp', $payment_call = TRUE) {
        if($payment_call) {
            // Convert array to query string.
            $parameters = http_build_query($parameters);
        }
        $curl_timeout = $this->config->get('novalnet_curl_timeout');
        // Perform Curl process.
        // if curl timeout is configured in shop admin, then assign configured values. Otherwise set the static value 240.

        $curl_timeout = (!empty($curl_timeout) && $curl_timeout > 240) ? $curl_timeout : 240;

        $proxy = $this->config->get('novalnet_proxy');
        $proxy = is_null($proxy) ? '' : trim($proxy);
        $ch    = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $curl_timeout);

        // if proxy value is not empty, then set to curl option
        if (!empty($proxy)) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        $reponse = curl_exec($ch);
        curl_close($ch);

        if($payment_call) {
            parse_str($reponse, $reponse);
        }
        // Return the parsed string.
        return $reponse;
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
     * To get the Novalnet server URL
     *
     * @param       $type
     * @return      string
     */
    public function getUrl($type)
    {
        $payment = array(
            'online_transfer'      => 'https://payport.novalnet.de/online_transfer_payport',
            'paypal'               => 'https://payport.novalnet.de/paypal_payport',
            'giropay'              => 'https://payport.novalnet.de/giropay',
            'pci_payport'          => 'https://payport.novalnet.de/pci_payport',
            'przelewy24'           => 'https://payport.novalnet.de/globalbank_transfer',
            'nn_infoport'          => 'https://payport.novalnet.de/nn_infoport.xml',
            'online_bank_transfer' => 'https://payport.novalnet.de/online_banktransfer',
        );
        return ($payment[$type]);
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
     * Get Basic template details.
     *
     * @param   $payment_name
     * @return  array
     */
    public function getBasicDetails($payment_name) {

        $this->unsetBeforePaymentSession($payment_name);
        $payment_logo = ($this->config->get('payment_novalnet_payment_logo') == 1) ? $this->language->get('payment_logo') : '';
        return array(
            'payment_logo'       => $payment_logo,
            'test_mode'          => $this->config->get($payment_name . '_testmode'),
            'buyer_notification' => trim(strip_tags(html_entity_decode($this->config->get($payment_name . '_buyer_notification'), ENT_QUOTES, 'UTF-8'))),
            'continue' => $this->url->link('checkout/success'),
            'text_loading' => $this->language->get('text_loading'),
        );
    }

    /**
     * Get shopping type details.
     *
     * @param  $payment_name
     * @param  $data
     * @return array
     */
    public function getShoppingTypeDetails($payment_name, $data) {

        $payment_type = $payment_name;
        $payment_name = 'payment_'.$payment_name;
        $data['shopping_type'] = $shopping_type   = $this->config->get($payment_name . '_shopping_type');
        $data['one_click_process_enabled'] = false;
        $data['one_click_desc'] = 0;
        $user_masked_data = array();

        // Check for on click process.
        if ($shopping_type == 'ONE_CLICK') {
            $data['one_click_process_enabled'] = true;
            $data['one_click_desc'] = 1;
            $data['given_details_style']        = 'display:block';
            $data['new_details_style']          = 'display:none';
            $data['customer_oneclick_style']    = 'display:none';

            $user_masked_data               = $this->getMaskingDetails($payment_type);
            if (!empty($user_masked_data)) {

                // Assign masked TID in SESSION.

                $this->session->data[$payment_name]['masked_tid'] = $user_masked_data['tid'];
            } else {
                $data['one_click_process_enabled'] = false;
                $data['given_details_style']        = 'display:none';
                $data['new_details_style']          = 'display:block';
                $data['customer_oneclick_style']    = 'display:block';
            }
        } else {
            $data['given_details_style']        = 'display:none';
            $data['new_details_style']          = 'display:block';
            $data['customer_oneclick_style']    = 'display:block';
        }

        if(empty($this->session->data['customer_id'])) {
            $data['one_click_desc'] = 0;
        } else if ($payment_name == 'payment_novalnet_cc') {
            if( $this->config->get('payment_novalnet_cc_3d_enable') == 'yes') {
                    $data['one_click_desc'] = 0;
            }
        }
        $data['user_masked_data'] = $user_masked_data;
        return $data;
    }

    /**
     * Fetch the masking details of user's previous order
     *
     * @param  $payment_name
     * @return array
     */
    public function getMaskingDetails($payment_name)
    {


        $masked_data = array();
        if(!empty($this->session->data['customer_id'])) {
            $query = $this->db->query("SELECT additional_details, one_click_details, tid FROM " . DB_PREFIX . "novalnet_transactions WHERE customer_id = '" . $this->session->data['customer_id'] . "' AND payment_type='" . $payment_name . "' AND create_payment_ref='1'  ORDER BY id DESC");
            // Check for query result.
            if (! empty($query->row['additional_details'])) {
                $masked_data        = (array)json_decode($query->row['additional_details']);
                $masked_data['tid'] = $query->row['tid'];
            }
        }
        return $masked_data;
    }

    /**
     * Get guarantee details
     *
     * @param   $payment_name
     * @param   $order_info
     * @param   $data
     * @return  array
     *
     */
    public function getGuaranteeDetails($payment_name, $order_info, $data = array()) {

        $data['enable_guarantee_payment'] = (boolean)$this->config->get($payment_name . '_guarantee_payment_enable');
        $data['guarantee_payment_error'] = false;

        if ($data['enable_guarantee_payment']) {
            $data['dob_label'] = $this->language->get('text_guarantee_payment_dob');

            // Default value.
            $minimum_amount = (int)trim($this->config->get($payment_name . '_guarantee_minimum_order_amount'));

            if ($minimum_amount == '') {
                $minimum_amount = 999;
            }
            $order_amount   = (int)$this->getAmountFormat($order_info['total'], $order_info['currency_value']);

            // Billing address.
           $billing_address = array(
                'address_1' => $order_info['payment_address_1'],
                'address_2' => $order_info['payment_address_2'],
                'postcode'  => $order_info['payment_postcode'],
                'city'      => $order_info['payment_city'],
                'country'   => $order_info['payment_country']
            );

            $shipping_address = array(
                'address_1' => $order_info['shipping_address_1'],
                'address_2' => $order_info['shipping_address_2'],
                'postcode'  => $order_info['shipping_postcode'],
                'city'      => $order_info['shipping_city'],
                'country'   => $order_info['shipping_country']
            );
            $data['error_msg'] = '';
            // Process as guarantee payment.
            if (!$this->validateAllowedCountries($order_info['payment_iso_code_2'])) {
                $data['error_msg'] = $this->language->get('error_guarantee_country');
            }
            if ($order_info['currency_code'] != 'EUR') {
                $data['error_msg'] .= $this->language->get('error_guarantee_currency');
            }
            if ($billing_address != $shipping_address) {
                $data['error_msg'] .= $this->language->get('error_guarantee_billing_shipping_address');
            }
            if ($order_amount < $minimum_amount) {
                $data['error_msg'] .= $this->language->get('error_guarantee_minimum_amount') . $minimum_amount . $this->language->get('error_eur');

            }

            if (empty($data['error_msg'])) {
                $data['customers_dob']     = '';
                $data['show_fraud_module']     = false;
                $data['date_format_error'] = $this->language->get('error_telephone_empty');
                $this->session->data[$payment_name]['guarantee_payment'] = true;
                $this->session->data[$payment_name]['fraud_module_enabled'] = false;
                $this->session->data[$payment_name]['guarantee_payment_error'] = false;

            } elseif ($this->config->get($payment_name . '_guarantee_payment_force') == '1') {
                // Process as normal payment.
                $data['enable_guarantee_payment'] =  $this->session->data[$payment_name]['guarantee_payment'] = $this->session->data[$payment_name]['guarantee_payment_error'] = false;
                $this->session->data[$payment_name]['fraud_module_enabled'] = true;
            } else {
                // Show error on payment field/ checkout.
                $this->session->data[$payment_name]['guarantee_payment'] = false;
                $this->session->data[$payment_name]['guarantee_payment_error'] = true;
                $this->session->data[$payment_name]['fraud_module_enabled'] = $data['show_fraud_module'] = false;
                $data['guarantee_payment_error'] = false;
                $data['guarantee_payment_error_text'] = '';
            }
        } else {
            $this->session->data[$payment_name]['guarantee_payment'] = $this->session->data[$payment_name]['guarantee_payment_error'] = false;
        }
        $data['guarantee_payment_force'] = $this->config->get($payment_name . '_guarantee_payment_force');


        return $data;
    }

    /**
     * Convert shop amount into server amount format
     *
     * @param  $amount
     *
     * @param  $currency_value
     *
     * @return integer
     */
    public function getAmountFormat($amount , $currency_value = '')
    {
        $amount = (!empty($currency_value)) ? ($amount * $currency_value) : $amount;

        return (sprintf('%0.2f', $amount) * 100);
    }

    /**
     * Form One click process parameters
     *
     * @param   $parameters
     * @param   $payment_name
     * @param   $shopping_type
     * @param   $customer_one_click
     * @return  array
     */
    public function formOneClickParams($parameters, $payment_name, $shopping_type, $customer_one_click) {

        if ($shopping_type == 'ONE_CLICK'  ) {
            $payment_type = 'payment_'.$payment_name;
            if(!empty($this->request->request[$payment_name . '_one_click_shopping'])) {

                $parameters['payment_ref'] = $this->session->data[$payment_type]['masked_tid'];


            } elseif($customer_one_click=='True') {
                $parameters['create_payment_ref'] = '1';

            }
        }

        return $parameters;
    }

    /* Check for zero amount booking
     *
     * @param  $parameters
     * @param  $payment_name
     * @param  $zero_booking
     */
    public function zeroBookingParams($parameters, $zero_booking, $payment_name) {

        // Check the zero amount booking.
        if ($zero_booking == 'ZERO_AMOUNT' && $this->getTariffId(true) == '2') {

            // Assign payment parameters in SESSION.
            $this->session->data[$payment_name]['payment_params'] = $parameters;
            $parameters['amount'] = 0;
            $parameters['create_payment_ref'] = 1;
        }
        return $parameters;
    }

    /**
     * Assign on-hold to payment parameter
     *
     * @param  $parameters
     * @param  $amount
     * @param  $payment
     *
     * return  $parameters
     */
    public function getOnholdParameter($parameters, $amount, $payment)
    {
        $onhold_limit_amount = trim($this->config->get($payment.'_manual_limit'));
        if($this->config->get($payment.'_authenticate') == 0) {
        return $parameters;
    }
        if ($this->config->get($payment.'_authenticate') == 1 ) {
            if (empty($onhold_limit_amount) || ($amount >= $onhold_limit_amount)) {
                $parameters['on_hold'] = '1';
            }
        }
        return $parameters;
    }

    /**
     * Form Guarantee payment parameters
     *
     * @param  $parameters
     * @param  $payment_name
     * @return array
     */
    public function formGuaranteePaymentParams($parameters, $payment_name) {

        // Load Order information.
        $order_info          = $this->model_checkout_order->getOrder($parameters['order_no']);
        // Get Guarantee details.
        $this->getGuaranteeDetails($payment_name, $order_info, array());

       if(!empty($this->session->data[$payment_name]['process_guarantee'])) {
            $payment_code = ($payment_name == 'payment_novalnet_invoice') ?  'novalnet_invoice_guarantee' : 'novalnet_sepa_guarantee';
            $parameters['payment_type'] = $this->payment_details[$payment_code]['payment_type'];
            $parameters['key'] = $this->session->data['nn_payment_key'] = $this->payment_details[$payment_code]['key'];
            if(empty($this->request->request[$payment_name . '_company'])) {
                $dob = !empty($this->request->request[$payment_name . '_one_click_shopping']) ? $this->request->request[$payment_name . '_one_click_dob'] : $this->request->request[$payment_name . '_dob'];
                $parameters['birth_date']   = date('Y-m-d', strtotime($dob));
            }

        }
        return $parameters;
    }

    /**
     * Validate guarantee process
     *
     * @param  $payment_name
     * @return string
     *
     */
    public function validateGuaranteeProcess($payment_name) {
        $message = '';

        $payment_name = 'payment_'.$payment_name;

        // Validate Age.
        !empty($this->request->request[$payment_name . '_company'] && !empty($this->session->data[$payment_name]['guarantee_payment'])) ? $this->session->data[$payment_name]['process_guarantee'] = true : $this->session->data[$payment_name]['process_guarantee'] = false;
        if (!empty($this->session->data[$payment_name]['guarantee_payment']) && empty($this->request->request[$payment_name . '_company'])) {
            $dob = !empty($this->request->request[$payment_name . '_one_click_shopping']) ? $this->request->request[$payment_name . '_one_click_dob'] : (isset($this->request->request[$payment_name . '_dob']) ? $this->request->request[$payment_name . '_dob'] : '');

            $this->session->data[$payment_name]['process_guarantee'] = true;

            if (empty($dob)) {
                $message = $this->language->get('error_dob_empty');
            }elseif (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dob)) {
                $message = $this->language->get('error_dob_invalid_format');
            } elseif (time() < strtotime('+18 years', strtotime($dob))) {
                $message = $this->language->get('error_sepa_age_below_18');
            }
        } elseif (!empty($this->session->data[$payment_name]['guarantee_payment_error'])) {
            $message = $this->language->get('text_guarantee_payment_warning_msg');

        }

        if ($this->config->get($payment_name . '_guarantee_payment_force') == '1' && $message !== '') {
            $this->session->data[$payment_name]['guarantee_payment'] = $this->session->data[$payment_name]['process_guarantee'] = false;
            $message = '';
        }

        return $message;
    }

    /**
     * Get the response message
     *
     * @param $data
     *
     * @return string
     */
    public function setResponseMessage($data)
    {
        if (isset($data['status_text'])) {
            return $data['status_text'];
        } elseif(isset($data['status_desc'])) {
            return $data['status_desc'];
        } elseif(isset($data['status_message'])) {
            return $data['status_message'];
        } else {
            return $this->language->get('error_payment_not_successful');
        }
    }

    /**
     * Validate payment fields.
     *
     * @param  $input_fields
     * @param  $payment_name
     *
     * @return string
     */
    public function validatePaymentFields($input_fields, $payment_name) {

        foreach($input_fields as $input_field) {
            $value = trim($this->request->request[$input_field]);
            if(empty($value)) {
                return $this->language->get($payment_name . '_payment_details_error');
            }
        }
        return '';
    }

    /**
     * Get language code.
     *
     * @param   $language
     * @param   $upper_case
     * @return  string
     */
    public function getLanguageCode($language, $upper_case = true) {
        $language_code = explode('-', $language);
        return ($upper_case) ? strtoupper($language_code['0']) : strtolower($language_code);
    }

    /**
     * Display payment method based on zone and amount
     *
     * @param   $payment_name
     * @param   $address
     * @param   $total
     * @return  array
     */
    public function showPaymentMethod($payment_name, $address, $total) {
        $geo_zone_id = (int)$this->config->get('payment_'.$payment_name . '_geo_zone_id');
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . $geo_zone_id . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
        $minimum_total = $this->config->get('payment_'.$payment_name . '_total');
        $status = ($minimum_total > 0 && $minimum_total > $total*100) ? false : ((!$geo_zone_id) ? true : (($query->num_rows) ? true : false ));
        if ($status) {
            return array(
                'code' => $payment_name,
                'title' => $this->language->get('text_title'),
                'terms'      => '',
                'sort_order' => $this->config->get('payment_'.$payment_name . '_sort_order')
            );
        }
        return array();
    }
}
