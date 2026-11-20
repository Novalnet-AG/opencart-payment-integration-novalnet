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
 * Script : novalnet_prepayment.php
 */

include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['novalnet_heading_title']    = $_['heading_title'] = $_['text_novalnet_prepayment_title'] = 'Vorauskasse';
$_['payment_error']             = 'Wählen Sie mindestens einen Verwendungszweck aus.';
$_['text_prepayment_duedate']   = 'Fälligkeitsdatum (in Tagen)';
$_['text_prepayment_duedate_desc'] = 'Geben Sie die Anzahl der Tage ein, binnen derer die Zahlung bei Novalnet eingehen soll (muss größer als 7 Tage sein). Falls dieses Feld leer ist, werden 14 Tage als Standard-Zahlungsfrist gesetzt';
$_['text_novalnet_prepayment']  = '<img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" />';
$_['logo_novalnet_prepayment']  = '<a href="https://www.novalnet.de/vorkasse-internet-payment" target="_blank"><img src="../image/payment/novalnet/novalnet_prepayment.png" border="0" alt="Novalnet Vorauskasse" title="Novalnet Vorauskasse" /></a>';
