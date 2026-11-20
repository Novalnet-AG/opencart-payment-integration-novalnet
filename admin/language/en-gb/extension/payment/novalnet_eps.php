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
 * Script : novalnet_eps.php
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title']     = 'eps';
$_['text_success']      = 'Success: You have modified eps details!';
$_['text_novalnet_eps'] = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_eps'] = '<img src="../image/payment/novalnet/novalnet_eps.png" border="0" alt="Novalnet eps" title="Novalnet eps" /></a>';
$_['entry_image']       = 'Payment Logo Upload';
