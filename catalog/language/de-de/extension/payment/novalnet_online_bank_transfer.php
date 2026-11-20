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
 * Script : novalnet_onlinebanktransfer.php
 */
include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['text_title']                      = $_['text_novalnet_online_bank_transfer_title'] = 'Onlineüberweisung';
$_['text_paypal_payment_description'] = 'Sie werden zu Onlineüberweisung weitergeleitet. Um eine erfolgreiche Zahlung zu gewährleisten, darf die Seite nicht geschlossen oder neu geladen werden, bis die Bezahlung abgeschlossen ist';
$_['payment_logo']                    = '<img id="novalnet_onlinebanktransfer_logo" src="image/payment/novalnet/novalnet_onlinebanktransfer.png" alt="Onlineüberweisung" title="Onlineüberweisung" style="width:59px; height:21px;"/>';
