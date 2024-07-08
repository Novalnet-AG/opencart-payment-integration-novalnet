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
include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['text_title']                             = $_['text_novalnet_paypal_title']             = 'PayPal';
$_['text_paypal_payment_description'] = 'Sie werden zu PayPal weitergeleitet. Um eine erfolgreiche Zahlung zu gewährleisten, darf die Seite nicht geschlossen oder neu geladen werden, bis die Bezahlung abgeschlossen ist';
$_['payment_logo']                           = '<img id="novalnet_paypal_logo" src="image/payment/novalnet/novalnet_paypal.png" alt="PayPal" title="PayPal" style="width:60px; height:17px;" />';
$_['novalnet_paypal_new_payment_details']    = 'Eingegebene Kontodaten';
$_['novalnet_paypal_placed_payment_details'] = 'Neue Kontodaten für spätere Käufe hinzufügen';
$_['novalnet_paypal_transaction_id']         = 'PayPal Transaktions-ID: ';
$_['novalnet_paypal_novalnet_tid']           = 'Novalnet Transaktions-ID: ';
$_['save_card_details']               = 'Meine PayPal-Daten für zukünftige Bestellungen speichern';
