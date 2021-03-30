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
 * Script : novalnet_cc.php
 */
 
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title'] = $_['text_novalnet_cc_title'] = 'Credit Card';
$_['text_success']                       = 'Success: You have modified Credit Card details!';
$_['entry_enable_3d']                    = 'Enable 3D secure';
$_['entry_enable_3d_desc']               = 'The 3D-Secure will be activated for credit cards. The issuing bank prompts the buyer for a password what, in turn, help to prevent a fraudulent payment. It can be used by the issuing bank as evidence that the buyer is indeed their card holder. This is intended to help decrease a risk of charge-back.';
$_['entry_display_amex_logo']            = 'Display AMEX logo';
$_['entry_display_amex_logo_desc']       = 'Display AMEX logo in checkout page';
$_['entry_display_maestro_logo']         = 'Display Maestro logo';
$_['entry_display_maestro_logo_desc']    = 'Display Maestro logo in checkout page';
$_['onhold_payment_action']              = 'Payment action';
$_['text_novalnet_cc']                   = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_cc']                   = '<img src="../image/payment/novalnet/novalnet_cc.png" border="0" alt="Novalnet Credit Card" title="Novalnet Credit Card"/>&nbsp;<img src="../image/payment/novalnet/novalnet_cc_mastercard.png" border="0" alt="Novalnet Credit Card" title="Novalnet Credit Card" />';
$_['text_iframe_configuration']          = 'CSS settings for Credit Card iframe';
$_['text_iframe_form_appearance']        = 'Form appearance';
$_['text_iframe_label']                  = 'Label';
$_['text_iframe_css_text']               = 'CSS Text';
$_['text_iframe_input']                  = 'Input';
$_['authorize']                          = 'Authorize';
$_['capture']                            = 'Capture';
$_['entry_force_enable_3d']              = 'Force 3D secure on predefined conditions';
$_['entry_force_enable_3d_desc']         = 'If 3D secure is not enabled in the above field, then force 3D secure process as per the &quot;Enforced 3D secure (as per predefined filters & settings)&quot; module configuration at the Novalnet Merchant Administration portal. If the predefined filters & settings from Enforced 3D secure module are met, then the transaction will be processed as 3D secure transaction otherwise it will be processed as non 3D secure. Please note that the "Enforced 3D secure (as per predefined filters & settings)" module should be configured at Novalnet Merchant Administration portal prior to the activation here. For further information, please refer the description of this fraud module at "Fraud Modules" tab, below "Projects" menu, under the selected project in Novalnet Merchant Administration portal or contact Novalnet support team.';
