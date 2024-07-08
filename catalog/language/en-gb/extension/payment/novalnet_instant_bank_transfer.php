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
 * Script : novalnet_instant_bank_transfer.php
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['text_title'] = $_['text_novalnet_instant_bank_transfer_title'] = 'Sofort';
$_['text_paypal_payment_description'] = 'You will be redirected to Sofort. Please don’t close or refresh the browser until the payment is completed';
$_['payment_logo']                    = '<img id="novalnet_instantbank_logo" src="image/payment/novalnet/novalnet_banktransfer.png" alt="Instant Bank Transfer" title="Instant Bank Transfer" style="width:40px; height:25px;"/>';
