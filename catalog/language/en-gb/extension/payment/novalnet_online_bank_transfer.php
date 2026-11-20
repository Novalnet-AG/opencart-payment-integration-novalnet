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
 * Script : novalnet_online_bank_transfer.php
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['text_title'] = $_['text_novalnet_online_bank_transfer_title'] = 'Online bank transfer';
$_['text_paypal_payment_description'] = 'You will be redirected to Online bank transfer. Please don’t close or refresh the browser until the payment is completed';
$_['payment_logo']                    = '<img id="novalnet_onlinebanktransfer_logo" src="image/payment/novalnet/novalnet_onlinebanktransfer.png" alt="Online bank transfer" title="Online bank transfer" style="width:40px; height:25px;"/>';
