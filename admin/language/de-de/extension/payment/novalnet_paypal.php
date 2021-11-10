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
$_['novalnet_heading_title'] = $_['heading_title'] = 'PayPal';
$_['paypal_pending_status']  = 'Bestellstatus der ausstehenden Zahlung';
$_['text_novalnet_paypal']   = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_paypal']   = '<img src="../image/payment/novalnet/novalnet_paypal.png" border="0" alt="Novalnet PayPal" title="Novalnet PayPal" />';
$_['paypal_one_click_info']  = 'Um diese Option zu verwenden, müssen Sie die Option Billing Agreement (Zahlungsvereinbarung) in Ihrem PayPal-Konto aktiviert haben. Kontaktieren Sie dazu bitte Ihren Kundenbetreuer bei PayPal.';
$_['onhold_payment_action']  = 'Bearbeitungsmaßnahme';
$_['authorize']    	     = 'Zahlung autorisieren';
$_['capture']    	     = 'Zahlung einziehen';
$_['entry_onhold_limit']                       = 'Limit für onhold-Buchungen setzen (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_onhold_limit_desc']                  = 'Falls der Bestellbetrag das angegebene Limit übersteigt, wird die Transaktion ausgesetzt, bis Sie diese selbst bestätigen.';
