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
$_['novalnet_heading_title'] = $_['heading_title'] = $_['text_novalnet_cc_title'] = 'Credit/Debit Cards';
$_['text_success']                       = 'Success: You have modified Credit Card details!';
$_['entry_enable_3d']                    = 'Enforce 3D secure payment outside EU';
$_['entry_enable_3d_desc']               = 'By enabling this option, all payments from cards issued outside the EU will be authenticated via 3DS 2.0 SCA.';
$_['onhold_payment_action']              = 'Payment action';
$_['onhold_payment_action_desc']  = 'Choose whether or not the payment should be charged immediately. Capture completes the transaction by transferring the funds from buyer account to merchant account. Authorize verifies payment details and reserves funds to capture it later, giving time for the merchant to decide on the order';
$_['text_novalnet_cc']                   = '<a href="https://www.novalnet.com" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_cc']                   = '<img src="../image/payment/novalnet/novalnet_cc.png" border="0" alt="Novalnet Credit Card" title="Novalnet Credit Card"/>&nbsp;<img src="../image/payment/novalnet/novalnet_cc_mastercard.png" border="0" alt="Novalnet Credit Card" title="Novalnet Credit Card" />';
$_['text_iframe_configuration']          = 'CSS settings for iframe form';
$_['text_iframe_form_appearance']        = 'Form appearance';
$_['text_iframe_label']                  = 'Label';
$_['text_iframe_css_text']               = 'CSS Text';
$_['text_iframe_input']                  = 'Input';
$_['authorize']                          = 'Authorize';
$_['capture']                            = 'Capture';

