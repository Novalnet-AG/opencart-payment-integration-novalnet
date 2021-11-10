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
$_['entry_product_activation_key_desc']       = 'Enter Novalnet Product activation key';
$_['error_mandatory_fields']                  = 'Please fill in all the mandatory fields';
$_['error_email']                             = 'Your E-mail address is invalid';
$_['entry_merchant_id']                       = 'Merchant ID';
$_['entry_authcode']                          = 'Authentication code';
$_['entry_project_id']                        = 'Project ID';
$_['entry_tariff']                            = 'Tariff ID';
$_['entry_tariff_desc']                       = 'Select Novalnet tariff ID';
$_['entry_payment_access_key']                = 'Payment access key';
$_['entry_payment_logo']                      = 'Display payment method logo';
$_['entry_payment_logo_desc']                 = 'The payment method logo will be displayed on the checkout page';
$_['entry_referrer_id']                       = 'Referrer ID';
$_['entry_referrer_id_desc']                  = 'Enter the referrer ID of the person/company who recommended you Novalnet';
$_['entry_proxy_server']                      = 'Proxy server';
$_['entry_proxy_server_desc']                 = 'Enter the IP address of your proxy server along with the port number in the following format IP Address : Port Number (if applicable)';
$_['entry_gateway_timeout']                   = 'Gateway timeout (in seconds)';
$_['entry_gateway_timeout_desc']              = 'In case the order processing time exceeds the gateway timeout, the order will not be placed';
$_['entry_onhold_management']                 = 'Order status management for on-hold transaction(-s)';
$_['entry_onhold_confirm_status']             = 'Onhold order status';
$_['entry_onhold_cancel_status']              = 'Cancellation order status';
$_['entry_merchant_script_management']        = 'Merchant script management';
$_['entry_merchant_script_test_mode']         = 'Deactivate IP address control (for test purpose only)';
$_['entry_merchant_script_test_mode_desc']    = 'This option will allow performing a manual execution. Please disable this option before setting your shop to LIVE mode, to avoid unauthorized calls from external parties (excl. Novalnet).';
$_['entry_merchant_script_mail_notification'] = 'Enable E-mail notification for callback';
$_['entry_notification_url']                  = 'Notification URL';
$_['entry_notification_url_desc']             = 'The notification URL is used to keep your database/system actual and synchronizes with the Novalnet transaction status.';
$_['entry_email_to_addr']                     = 'E-mail address (To)';
$_['entry_email_to_addr_desc']                = 'E-mail address of the recipient';
$_['entry_email_bcc_addr']                    = 'E-mail address (Bcc)';
$_['entry_email_bcc_addr_desc']               = 'E-Mail address of the recipient for BCC';
$_['text_novalnet']                           = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['entry_admin_portal_src']                  = 'For additional configurations login to <a href="https://admin.novalnet.de" target="_blank" style="text-decoration: underline;">Novalnet Merchant Administration portal</a>. To login to the Portal you need to have an account at Novalnet. If you dont have one yet, please contact <a  href="mailto:sales@novalnet.de">sales@novalnet.de</a> / tel. +49 (089) 923068320';
$_['entry_paypal_admin_portal_src']           = 'To use the PayPal payment method please enter your PayPal API details in <a href="https://admin.novalnet.de/" target="_blank" style="text-decoration: underline;"> Novalnet Merchant Administration portal</a>';
$_['package_error']                           = 'Mentioned PHP Package(s) not available in this Server. Please enable it.';
