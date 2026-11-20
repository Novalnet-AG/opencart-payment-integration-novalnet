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
include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['text_title']                      = $_['text_novalnet_cc_title']          = 'Kredit- / Debitkarte';
$_['text_direct_payment_description'] = 'Der Betrag wird Ihrer Kredit-/Debitkarte belastet';
$_['text_payment_description']        = 'Der Betrag wird Ihrer Kredit-/Debitkarte belastet';
$_['text_cc_card_name']   = 'Name auf der Kreditkarte';
$_['text_cc_number_placeholder']   = 'XXXX XXXX XXXX XXXX';
$_['text_cc_date_placeholder'] = 'MM / YY';
$_['text_cc_cvc_placeholder']      = 'XXX';
$_['text_cc_cvc_hint'] = 'Was ist das?';
$_['text_cc_type']                    = 'Kartentyp';
$_['text_cc_holder']                  = 'Name des Karteninhabers';
$_['text_cc_number']                  = 'Kreditkartennummer';
$_['text_cc_expiry_date']             = 'Ablaufdatum';
$_['text_cc_cvc']                     = 'CVC/CVV/CID';
$_['novalnet_cc_payment_details_error']      = 'Ihre Kreditkartendaten sind ungültig.';
$_['novalnet_cc_new_card_details']    = 'Neue Kontodaten für spätere Käufe hinzufügen';
$_['novalnet_cc_given_card_details']  = 'Eingegebene Kontodaten';
$_['maestro_logo']                    = '<img class="novalnet_cc_logo" src="image/payment/novalnet/novalnet_maestro.png" alt="Kreditkarte" title="Kreditkarte" />';
$_['payment_logo']                    = '<img class="novalnet_cc_logo" src="image/payment/novalnet/novalnet_cc.png" alt="Kreditkarte" title="Kreditkarte" /><img class="novalnet_cc_logo" src="image/payment/novalnet/novalnet_cc_mastercard.png" alt="Kreditkarte" title="Kreditkarte" />';
$_['amex_logo']                       = '<img class="novalnet_cc_logo"  src="image/payment/novalnet/novalnet_amex.png" alt="Kreditkarte" title="Kreditkarte" />';
$_['save_card_details']               = 'Meine Kartendaten für zukünftige Bestellungen speichern';
