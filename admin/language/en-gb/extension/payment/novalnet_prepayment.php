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
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title'] = $_['text_novalnet_prepayment_title']          = 'Prepayment';
$_['text_success']                            = 'Success: You have modified Prepayment details!';
$_['text_prepayment_duedate']                             = 'Payment due date (in days)';
$_['text_prepayment_duedate_desc']                        = 'Enter the number of days to transfer the payment amount to Novalnet (must be greater than 7 days). In case if the field is empty, 14 days will be set as due date by default';
$_['text_novalnet_prepayment']                = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_prepayment']                = '<img src="../image/payment/novalnet/novalnet_prepayment.png" border="0" alt="Novalnet Prepayment" title="Novalnet Prepayment" />';
$_['entry_image']                             = 'Payment Logo Upload';
