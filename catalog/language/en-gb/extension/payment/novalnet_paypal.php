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
 * Script : novalnet_paypal.php
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['text_title']                             = $_['text_novalnet_paypal_title']             = 'PayPal';
$_['text_paypal_payment_description'] = 'You will be redirected to PayPal. Please don’t close or refresh the browser until the payment is completed';
$_['payment_logo']                           = '<img id="novalnet_paypal_logo" src="image/payment/novalnet/novalnet_paypal.png" alt="PayPal" title="PayPal" style="width:60px; height:17px;" />';
