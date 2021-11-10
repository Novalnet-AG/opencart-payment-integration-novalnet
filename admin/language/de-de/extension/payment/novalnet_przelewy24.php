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
 * Script : novalnet_przelewy24.php
 */

include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['novalnet_heading_title']    = $_['heading_title'] = 'Przelewy24';
$_['text_paypal_payment_description'] = 'Sie werden zu Przelewy24 weitergeleitet. Um eine erfolgreiche Zahlung zu gewährleisten, darf die Seite nicht geschlossen oder neu geladen werden, bis die Bezahlung abgeschlossen ist';
$_['przelewy24_pending_status'] = 'Bestellstatus der ausstehenden Zahlung';
$_['przelewy24_pending_status_desc'] = 'Wählen Sie, welcher Status für Bestellungen mit ausstehender Zahlung verwendet wird ';
$_['text_novalnet_przelewy24']  = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_przelewy24']  = '<img src="../image/payment/novalnet/novalnet_przelewy24.png" border="0" alt="Novalnet Przelewy24" title="Novalnet Przelewy24" />';
