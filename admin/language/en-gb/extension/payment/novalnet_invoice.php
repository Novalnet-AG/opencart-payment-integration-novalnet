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
 * Script : novalnet_invoice.php
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title'] = $_['text_novalnet_invoice_title'] = 'Invoice';
$_['text_success']                                     = 'Success: You have modified Invoice details!';
$_['text_invoice_duedate']                             = 'Payment due date (in days)';
$_['text_invoice_duedate_desc']                        = 'Enter the number of days to transfer the payment amount to Novalnet (must be greater than 7 days). In case if the field is empty, 14 days will be set as due date by default';
$_['payment_error']                                    = 'Please select atleast one payment reference.';
$_['text_novalnet_invoice']                            = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_invoice']                            = '<img src="../image/payment/novalnet/novalnet_invoice.png" border="0" alt="Novalnet Invoice" title="Novalnet Invoice" />';
$_['onhold_payment_action']			       			   = 'Payment action';
$_['onhold_payment_action_desc']  = 'Choose whether or not the payment should be charged immediately. Capture completes the transaction by transferring the funds from buyer account to merchant account. Authorize verifies payment details and reserves funds to capture it later, giving time for the merchant to decide on the order';
$_['authorize']    			 	        			   = 'Authorize';
$_['capture']    				       				   = 'Capture';
