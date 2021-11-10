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
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['novalnet_heading_title']        	 = $_['heading_title']         = 'PayPal';
$_['text_success']         				 = 'Success: You have modified PayPal details!';
$_['paypal_pending_status']				 = 'Order status for the pending payment';
$_['text_novalnet_paypal'] 				 = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_paypal']  			 = '<img src="../image/payment/novalnet/novalnet_paypal.png" border="0" alt="Novalnet PayPal" title="Novalnet PayPal" />';
$_['paypal_one_click_info']  			 = 'In order to use this option you must have billing agreement option enabled in your PayPal account. Please contact your account manager at PayPal.';
$_['onhold_payment_action']    			 = 'Payment action';
$_['authorize']    			 			 = 'Authorize';
$_['capture']    						 = 'Capture';
