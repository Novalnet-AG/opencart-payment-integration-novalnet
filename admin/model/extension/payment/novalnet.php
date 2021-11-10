<?php

/**
 * Create the novalnet payment tables
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

class ModelExtensionPaymentNovalnet extends Model
{
    /**
     * Create table for Novalnet payment modules
     *
     * @param       none
     * @return      none
     */
    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "novalnet_transactions (
            id int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto Increment ID',
            order_no int(11) unsigned NOT NULL COMMENT 'Order ID from shop',
            tid bigint(20) unsigned NOT NULL COMMENT 'Novalnet Transaction Reference ID',
            gateway_status varchar(9) NOT NULL COMMENT 'Novalnet transaction status',
            payment_type varchar(100) NOT NULL COMMENT 'Novalnet payment type',
            payment_id int(11) unsigned NOT NULL COMMENT 'Payment ID',
            customer_id int(11) unsigned DEFAULT NULL COMMENT 'Customer ID from shop',
            create_payment_ref ENUM('0', '1') COMMENT 'Create payment reference',
            payment_configurations text COMMENT 'Store payment configuration details',
            transaction_details text COMMENT 'Store transaction details',
            one_click_details text COMMENT 'Stroe one click details',
            zero_amount_details text COMMENT 'Store zero amount details',
            additional_details text COMMENT 'Store additional details',
            `date` datetime NOT NULL COMMENT 'Transaction Date for reference',
            PRIMARY KEY (id),
            KEY tid (tid),
            KEY order_no (order_no)
        ) COMMENT='Novalnet Transaction History'");
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "novalnet_recurring_transactions (
            id int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto Increment ID',
            order_no int(11) unsigned NOT NULL COMMENT 'Order ID from shop',
            order_recurring_id int(11) unsigned NOT NULL COMMENT 'Order recurring id',
            tid bigint(20) unsigned NOT NULL COMMENT 'Novalnet Recurring Transaction Reference ID',
            amount varchar(50) DEFAULT NULL COMMENT 'Recurring amounts',
            payment_type varchar(100) NOT NULL COMMENT 'Novalnet payment type',
            transaction_details text COMMENT 'Store recurring transaction details',
            status varchar(10) DEFAULT NULL COMMENT 'Recurring order status',
            date_added datetime NOT NULL COMMENT 'Transaction Date for reference',
            PRIMARY KEY (id),
            KEY tid (tid),
            KEY order_no (order_no),
            KEY order_recurring_id (order_recurring_id)
        ) COMMENT='Novalnet Recurring Transaction Details'");
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "novalnet_subscriptions (
            id int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto increment ID',
            order_no int(11) unsigned NOT NULL COMMENT 'Order ID from shop',
            order_recurring_id int(11) unsigned NOT NULL COMMENT 'Order recurring id',
            tid bigint(20) unsigned NOT NULL COMMENT 'Novalnet Transaction Reference ID',
            next_subs_cycle date COMMENT 'Next Recurring date',
            trial_details text COMMENT 'Store subscription trial details',
            recurring_details text COMMENT 'Store subscription recurring details',
            additional_details text COMMENT 'Store subscription additional details',
            recurring_date_added date COMMENT 'Recurring date added',
            PRIMARY KEY (id),
            KEY order_no (order_no),
            KEY order_recurring_id (order_recurring_id)
        ) COMMENT='Novalnet Subscription Transaction Details'");
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "novalnet_merchant_script (
            id int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Auto Increment ID',
            order_no int(11) unsigned NOT NULL COMMENT 'Order ID from shop',
            original_tid bigint(20) unsigned DEFAULT NULL COMMENT 'Original Transaction ID',
            callback_tid bigint(20) unsigned NOT NULL COMMENT 'Callback Reference ID',
            payment_type varchar(100) NOT NULL COMMENT 'Callback Payment Type',
            amount int(11) DEFAULT NULL COMMENT 'Amount in cents',
            `date` datetime NOT NULL COMMENT 'Callback DATE TIME',
            PRIMARY KEY (id),
            KEY order_no (order_no)
        ) COMMENT='Novalnet Callback Details'");
    }


    /**
     * Return template details
     *
     * @param       $payment_name
     * @return      array
     */
    public function getTemplateDetails($payment_name) {

        $this->load->model('localisation/order_status');
        $this->load->model('localisation/geo_zone');
        return array(
            'breadcrumbs'   => array(),
            'breadcrumbs'   => array(
                array(
                    'text' => $this->language->get('text_home'),
                    'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
                ),
                array(
                    'text' => $this->language->get('text_extension'),
                    'href' => $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
                ),
                array(
                    'text' => $this->language->get('heading_title'),
                    'href' => $this->url->link('extension/payment/' . $payment_name, 'user_token=' . $this->session->data['user_token'], true)
                ),
            ),
            'order_statuses'    => $this->model_localisation_order_status->getOrderStatuses(),
            'geo_zones' => $this->model_localisation_geo_zone->getGeoZones(),
            'action'    => $this->url->link('extension/payment/' . $payment_name, 'user_token=' . $this->session->data['user_token'], true),
            'cancel'    => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true),
            'button_save'    => $this->language->get('button_save'),
            'button_cancel'    => $this->language->get('button_cancel'),
            'language'    => $this->language->get('code'),
            'header'    => $this->load->controller('common/header'),
            'column_left'    => $this->load->controller('common/column_left'),
            'footer'    => $this->load->controller('common/footer'),
        );
    }

    /**
     * Store payment configuration details
     *
     * @param       $payment_name
     * @return      none
     */
    public function storeConfigurations($payment_name) {
        $this->load->model('setting/setting');

        $this->model_setting_setting->editSetting($payment_name, $this->request->post);
        $this->session->data['success'] = $this->language->get('text_success');
        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));


    }

    /**
     * Check whether the value is numeric or not
     *
     * @param       $input
     * @return      boolean
     */
    public function isNumeric($input) {
        return preg_match("/^[0-9]+$/", trim($input));
    }

    /**
     * Get Novalnet order details
     *
     * @param       $order_no
     * @return      $transaction_details
     */
    public function getNovalnetOrders($order_no) {
        $db_details = $this->db->query('SELECT tid, gateway_status, payment_type, payment_id, customer_id, payment_configurations, transaction_details, additional_details, zero_amount_details, date FROM ' . DB_PREFIX . 'novalnet_transactions WHERE order_no = ' . $order_no );
        $transaction_details = $db_details->row;

        // Decode the encoded datas.
        $transaction_details['transaction_details']    = !empty($db_details->row['transaction_details']) ? json_decode($db_details->row['transaction_details'], true) : '';
        $transaction_details['additional_details']     = !empty($db_details->row['additional_details']) ? json_decode($db_details->row['additional_details'], true) : '';
        $transaction_details['payment_configurations'] = !empty($db_details->row['payment_configurations']) ? json_decode($db_details->row['payment_configurations'], true) : '';
        $transaction_details['zero_amount_details']    = !empty($db_details->row['zero_amount_details']) ? json_decode($db_details->row['zero_amount_details'], true) : '';

        return $transaction_details;
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
     * Update order details Novalnet tables
     *
     * @param       $order_details
     * @param       $order_manage_status
     * @param       $status
     * @return      none
     */
    public function orderDetailsUpdate($order_details, $order_manage_status, $status) {
            //Update status in order table
            $this->dbUpdate('order', array(
                'order_status_id' => $status
            ), 'order_id=' . $this->request->post['order_no']);

            //Insert details into order_history table
            $this->dbInsert('order_history', array(
                'order_id',
                'order_status_id',
                'notify',
                'comment',
                'date_added'
            ), array(
                $this->request->post['order_no'],
                $status,
                1,
                '"' . $order_details['novalnet_comments'] . '"',
                '"' . date('Y-m-d H:i:s') . '"'
            ));

            //Update gateway_status and refund_amount in novalnet_transactions table
            $this->dbUpdate('novalnet_transactions', array(
                'gateway_status' => $order_manage_status
            ), 'order_no=' . $this->request->post['order_no']);
    }

    /**
     * Update booking details in Novalnet tables
     *
     * @param       $response
     * @param       $order_details
     * @return      none
     */
    public function updateBookingDetails($response, $order_details) {

        //Update booking details in novalnet_transaction_detail table
        $this->dbUpdate('novalnet_transactions', array(
            'tid' => $response['tid'],
            'transaction_details' => "'" . json_encode($order_details['transaction_details']) . "'",
            'gateway_status' => $response['tid_status'],
            'zero_amount_details' => 0
        ), 'order_no = ' . $response['order_no']);

        //Get order status id from order table
        $details = $this->dbSelect('order', 'order_status_id', 'order_id =' . $response['order_no']);

        //Insert details into order_history table
        $this->dbInsert('order_history', array(
            'order_id',
            'order_status_id',
            'notify',
            'comment',
            'date_added'
        ), array(
            $response['order_no'],
            $details['order_status_id'],
            1,
            '"' . $order_details['comments'] . '"',
            '"' . date('Y-m-d H:i:s') . '"'
        ));

        //Insert details into novalnet_callback_history table
        $this->dbInsert('novalnet_merchant_script', array(
            'order_no',
            'original_tid',
            'callback_tid',
            'payment_type',
            'amount',
            'date'
        ), array(
            $response['order_no'],
            $response['tid'],
            $response['tid'],
            '"' . $order_details['payment_type'] . '"',
            $order_details['transaction_details']['amount'],
            '"' . date('Y-m-d H:i:s') . '"'
        ));
    }

    /**
     * Show refund tab
     *
     * @param  $data
     * @return array
     */
    public function showRefundTab($data) {
        $data['show_refund'] = (!empty($data['order_details']['gateway_status']) && $data['order_details']['gateway_status'] == '100');

        if($data['show_refund']) {

            $this->load->model('sale/order');
            $order_info = $this->model_sale_order->getOrder($data['order_id']);

            $data['customer_name'] = $order_info['customer'];

            $data['show_refund_reference'] = date('Y-m-d') != date('Y-m-d', strtotime($data['order_details']['date']));

            foreach(array(
                'text_refund_process',
                'text_refund',
                'text_refund_amount',
                'text_cents',
                'text_refund_reference',
                'text_update',
                'text_refund_message',
                'error_amount_invalid'
            ) as $v){
                $data[$v] = $this->language->get($v);
            }
        }

        return $data;
    }

    /**
     * Show manage transaction tab
     *
     * @param  $data
     * @return array
     */
    public function showManageTransactionTab($data) {
        $data['show_manage_transaction'] = (!empty($data['order_details']['gateway_status']) && in_array($data['order_details']['gateway_status'], array('85', '91', '98', '99')));

        if ($data['show_manage_transaction']) {
            foreach(array(
                'text_manage_transaction_process',
                'text_status_select',
                'text_select',
                'text_confirm',
                'text_cancel_message',
                'text_capture_message',
                'text_cancel',
                'text_update',
            ) as $v){
                $data[$v] = $this->language->get($v);
            }
        }
        return $data;
    }

    /**
     * Show amount/ due date update tab
     *
     * @param  $data
     * @return array
     */
    public function showAmountDueDateUpdateTab($data) {

        //Get order status id from order table
        $details = $this->dbSelect('novalnet_merchant_script', 'SUM(amount) as order_amount', 'order_no =' . $data['order_id']);

        $data['show_amount_update'] = $data['show_due_date_update'] = (!empty($data['order_details']['gateway_status']) && $data['order_details']['gateway_status'] == '100' && $details['order_amount'] < $data['order_details']['transaction_details']['amount']);

        if ($data['show_amount_update']) {
            foreach(array(
                'text_transaction_amount',
                'text_amount_update',
                'text_amount_update_message',
                'text_cents',
                'text_amount_update_transaction_duedate',
                'text_amount_update_with_duedate_message',
                'text_update',
                'error_amount_update_duedate_future',
                'error_amount_update_duedate_invalid',
                'error_amount_invalid'
            ) as $v) {
                $data[$v] = $this->language->get($v);
            }
        }


        return $data;
    }

     /**
     * Show amount update and change expiry date tab for Cashpayment
     *
     * @param  $data
     * @return array
     */
    public function showAmountExpiryDateUpdateTab($data) {
        //Get order status id from order table
        $details = $this->dbSelect('novalnet_merchant_script', 'SUM(amount) as order_amount', 'order_no =' . $data['order_id']);

        $data['show_amount_update'] = $data['show_amount_expiry_date_update'] = (!empty($data['order_details']['gateway_status']) && $data['order_details']['gateway_status'] == '100' && $details['order_amount'] < $data['order_details']['transaction_details']['amount']);

        if ($data['show_amount_update']) {
            foreach(array(
                'text_transaction_amount',
                'text_amount_expiry_date_update',
                'text_amount_update_with_exipry_message',
                'text_cents',
                'text_slip_expiry_date',
                'text_update',
                'error_amount_update_duedate_future',
                'error_amount_update_duedate_invalid',
                'error_amount_invalid'
            ) as $v) {
                $data[$v] = $this->language->get($v);
            }
        }

        return $data;
    }

    /**
     * Show amount update tab
     *
     * @param  $data
     * @return array
     */
    public function showAmountUpdateTab($data) {
        $data['show_amount_update'] = (!empty($data['order_details']['gateway_status']) && $data['order_details']['gateway_status'] == '99');

        if ($data['show_amount_update']) {
            foreach(array(
                'text_transaction_amount',
                'text_amount_update',
                'text_amount_update_message',
                'text_refund_amount_duedate_change',
                'text_cents',
                'text_update',
                'error_amount_invalid'
            ) as $v){
                $data[$v] = $this->language->get($v);
            }
        }

        return $data;
    }

    /**
     * Show amount book tab
     *
     * @param  $data
     * @return array
     */
    public function showAmountBookTab($data) {
        $data['show_amount_book'] = !empty($data['order_details']['zero_amount_details']) && $data['transaction_details']['amount'] == '0';

        if ($data['show_amount_book']) {
            foreach(array(
                'text_booking_transaction_amount',
                'text_booking_transaction',
                'text_book',
                'text_cents',
                'text_book_message',
                'error_amount_invalid'
            ) as $v){
                $data[$v] = $this->language->get($v);
            }
        }

        return $data;
    }

    /**
     * Update invoice order details Novalnet tables
     *
     * @param       $order_comment
     * @param       $order_manage_status
     * @param       $status
     * @return      none
     */

    public function updateTransactionComments($order_comment, $order_manage_status, $status) {
        //Insert details into order_history table
        $this->dbInsert('order_history', array(
            'order_id',
            'order_status_id',
            'notify',
            'comment',
            'date_added'
        ), array(
            $this->request->post['order_no'],
            $status,
            1,
            '"' . $order_comment . '"',
            '"' . date('Y-m-d H:i:s') . '"'
        ));
    }

}
