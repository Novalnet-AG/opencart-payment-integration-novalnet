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
 * Script : novalnet_sepa.php
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['heading_title'] = $_['text_novalnet_sepa_title']                         = 'Direct Debit SEPA';
$_['text_extension']                                   = 'Extensions';
$_['text_success']                                     = 'Success: You have modified Direct Debit SEPA details!';
$_['text_sepa_due_date']                               = 'SEPA payment duration (in days)';
$_['text_sepa_due_date_desc']                          = 'Enter the number of days after which the payment should be processed (must be between 2 and 14 days)';
$_['error_duration_date']                              = 'SEPA Due date is not valid';
$_['text_novalnet_sepa']                               = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_sepa']                               = '<img src="../image/payment/novalnet/novalnet_sepa.png" border="0" alt="Novalnet Direct Debit SEPA" title="Novalnet Direct Debit SEPA" />';
$_['onhold_payment_action']    						   = 'Payment action';
$_['authorize']    			 			 			   = 'Authorize';
$_['capture']    						        	   = 'Capture';
