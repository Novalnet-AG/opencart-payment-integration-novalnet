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
 * Script : novalnet.php
 */

include_once(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title'] = 'Novalnet Global Configuration';
$_['text_success']                            = 'Success: You have modified Novalnet Global Configuration account details!';
$_['entry_cron_job_url']                      = 'Cron job URL';
$_['entry_cron_job_url_desc']                 = 'Set cron job to call this URL';
$_['entry_enable_payment']                    = 'Enable payment method';
$_['entry_product_activation_key']            = 'Product activation key';
$_['entry_product_activation_key_desc']       = 'Get your Product activation key from the Novalnet Admin Portal: PROJECT > Choose your project > Shop Parameters > API Signature (Product activation key)';
$_['entry_client_key']            			  = 'Client Key';
$_['error_mandatory_fields']                  = 'Please fill in the required fields';
$_['error_email']                             = 'Your E-mail address is invalid';
$_['entry_merchant_id']                       = 'Merchant ID';
$_['entry_authcode']                          = 'Authentication code';
$_['entry_project_id']                        = 'Project ID';
$_['entry_tariff']                            = 'Select Tariff ID';
$_['entry_tariff_desc']                       = 'Select a Tariff ID to match the preferred tariff plan you created at the Novalnet Admin Portal for this project';
$_['entry_payment_access_key']                = 'Payment access key';
$_['entry_payment_logo']                      = 'Display payment logo';
$_['entry_payment_logo_desc']                 = 'The payment method logo(s) will be displayed on the checkout page.';
$_['entry_onhold_management']                 = 'Order status management for on-hold transaction';
$_['entry_onhold_confirm_status']             = 'On-hold order status';
$_['entry_onhold_cancel_status']              = 'Canceled order status';
$_['entry_merchant_script_management']        = 'Notification / Webhook URL Setup ';
$_['entry_merchant_script_test_mode']         = 'Allow manual testing of the Notification / Webhook URL';
$_['entry_merchant_script_test_mode_desc']    = 'Enable this to test the Novalnet Notification / Webhook URL manually. Disable this before setting your shop live to block unauthorized calls from external parties';
$_['entry_merchant_script_mail_notification'] = 'Enable e-mail notification';
$_['entry_merchant_script_mail_notification_desc'] = 'Enable this option to notify the given e-mail address when the Notification / Webhook URL is executed successfully.';
$_['entry_notification_url']                  = 'Notification / Webhook URL';
$_['entry_notification_url_desc']             = 'Notification / Webhook URL is required to keep the merchant’s database/system synchronized with the Novalnet account (e.g. delivery status). Refer the Installation Guide for more information';
$_['entry_email_to_addr']                     = 'Send e-mail to';
$_['entry_email_to_addr_desc']                = 'Notification / Webhook URL execution messages will be sent to this e-mail';
$_['text_novalnet']                           = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['entry_admin_portal_src']                  = 'Please read the Installation Guide before you start and login to the <a href="https://admin.novalnet.de" target="_blank" style="text-decoration: underline;">Novalnet Admin Portal</a> using your merchant account. To get a merchant account, mail to <a  href="mailto:sales@novalnet.de">sales@novalnet.de</a> or call +49 (089) 923068320';
$_['entry_paypal_admin_portal_src']           = 'To use the PayPal payment method please enter your PayPal API details in <a href="https://admin.novalnet.de/" target="_blank" style="text-decoration: underline;"> Novalnet Merchant Administration portal</a>';
$_['package_error']                           = 'Mentioned PHP Package(s) not available in this Server. Please enable it.';
