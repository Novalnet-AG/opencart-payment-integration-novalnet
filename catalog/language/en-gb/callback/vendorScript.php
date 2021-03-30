<?php
/**
 * Novalnet callbackscript english language
 * This module is used for real time processing of
 * Payments in novalnet.
 *
 * Copyright (c) Novalnet
 *
 * Released under the GNU General Public License
 * This free contribution made by request.
 * If you have found this script useful a small
 * recommendation as well as a comment on merchant form
 * would be greatly appreciated.
 *
 * Script : vendorScript.php
 *
 * @author    Novalnet AG
 * @copyright Copyright by Novalnet
 * @license   https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 *
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_invoice.php');
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_prepayment.php');
$_['text_novalnet_testorder']         = 'Test order';
$_['text_novalnet_transactionid']     = 'Novalnet transaction ID : ';
$_['text_success_callback1']          = 'Novalnet Callback Script executed successfully for the TID:';
$_['text_success_callback2']          = ' with amount ';
$_['text_success_callback3']          = ' on ';
$_['text_success_callback4']          = ' Please refer PAID transaction in our Novalnet Merchant Administration with the TID: ';
$_['text_chargeback1']                = 'Novalnet callback received. Chargeback executed successfully for the TID: ';
$_['text_bookback']                   = 'Novalnet callback received. Refund/Bookback executed successfully for the TID: ';
$_['text_guarantee_pending_to_onhold_message']  = 'Novalnet callback received. The transaction status has been changed from pending to on hold for the TID: ';
$_['text_chargeback2']                = ' amount: ';
$_['text_chargeback4']                = ' The subsequent TID: ';
$_['text_novalnet_iban']              = 'IBAN ';
$_['text_novalnet_bic']               = 'BIC ';
$_['text_novalnet_bank']              = 'Bank : ';
$_['text_novalnet_amount']            = 'Amount : ';
$_['text_novalnet_eps_title']         = 'eps';
$_['text_novalnet_giropay_title']     = 'giropay';
$_['text_novalnet_ideal_title']       = 'iDEAL';
$_['text_novalnet_instant_bank_transfer_title'] = 'Instant Bank Transfer';
$_['text_novalnet_paypal_title']      = 'PayPal';
$_['text_novalnet_cc_title']          = 'Credit Card';
$_['text_novalnet_przelewy24_title']  = 'Przelewy24';
$_['transaction_cancel_message']       = 'The transaction has been canceled due to:';
$_['text_novalnet_error_code']        = 'Payment was not successful. An error occurred';
