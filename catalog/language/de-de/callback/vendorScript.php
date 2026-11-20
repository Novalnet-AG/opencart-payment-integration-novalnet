<?php
/**
 * Novalnet callbackscript german language
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
include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_invoice.php');
include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_prepayment.php');
$_['text_novalnet_testorder']         = 'Testbestellung';
$_['text_novalnet_transactionid']     = 'Novalnet Transaktions-ID: ';
$_['text_success_callback1']          = 'Die Gutschrift für die TID: ';
$_['text_success_callback2']          = ' in Höhe von wurde erfolgreich erhalten ';
$_['text_success_callback3']          = ' am , um ';
$_['text_success_callback4']          = ' Neue TID: ';
$_['text_success_callback5']          = 'für die Gutschrift.';
$_['text_chargeback1']                = 'Chargeback erfolgreich importiert für die TID: ';
$_['text_bookback']                   = 'Rückerstattung / Bookback erfolgreich ausgeführt für die TID: ';
$_['text_guarantee_pending_to_onhold_message']  = 'Der Status der Transaktion mit der TID: ';
$_['text_chargeback2']                = ' Betrag: ';
$_['text_chargeback4']                = ' Uhr. TID der Folgebuchung: ';
$_['text_novalnet_iban']              = 'IBAN: ';
$_['text_novalnet_bic']               = 'BIC: ';
$_['text_novalnet_bank']              = 'Bank: ';
$_['text_novalnet_amount']            = 'Betrag: ';
$_['text_novalnet_eps_title']         = 'eps';
$_['text_novalnet_ideal_title']       = 'iDEAL | Wero';
$_['text_novalnet_online_bank_transfer_title']= 'Onlineüberweisung';
$_['text_novalnet_paypal_title']      = 'PayPal';
$_['text_novalnet_cc_title']          = 'Kreditkarte';
$_['text_novalnet_przelewy24_title']  = 'Przelewy24';
$_['transaction_cancel_message']      = 'Die Transaktion wurde storniert. Grund:';
$_['text_novalnet_error_code']        = 'Die Zahlung war nicht erfolgreich. Ein Fehler trat auf.';
$_['text_invoice_transaction_confirm'] = 'Die Transaktion mit der TID: %s wurde erfolgreich bestätigt und das Fälligkeitsdatum auf %s gesetzt.';
$_['text_transaction_confirm']                         = 'Die Buchung wurde am %s um %s Uhr bestätigt.';


