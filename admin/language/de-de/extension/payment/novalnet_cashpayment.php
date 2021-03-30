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
 * Script : novalnet_cashpayment.php
 */

include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title'] = $_['text_novalnet_cashpayment_title']          = 'Barzahlen/viacash';
$_['payment_error']                           = 'Wählen Sie mindestens einen Verwendungszweck aus.';
$_['text_novalnet_cashpayment']                 = '<img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" />';
$_['logo_novalnet_cashpayment']                 = '<img src="../image/payment/novalnet/novalnet_cashpayment.png" border="0" alt="Novalnet Barzahlen/viacash" title="Novalnet Barzahlen/viacash" />';
