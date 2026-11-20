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
$_['novalnet_heading_title']              = $_['heading_title'] = 'Onlineüberweisung';
$_['text_novalnet_online_bank_transfer'] = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_online_bank_transfer'] = '<img src="../image/payment/novalnet/novalnet_onlinebanktransfer.png" border="0" alt="Novalnet Onlineüberweisung" title="Novalnet Onlineüberweisung" />';
