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
$_['text_title']                      = $_['text_novalnet_cc_title']          = 'Credit/Debit Cards';
$_['text_direct_payment_description'] = 'The amount will be debited from your credit/debit card';
$_['text_payment_description']        = 'The amount will be debited from your credit/debit card';
$_['text_cc_card_name']   = 'Name on card';
$_['text_cc_number_placeholder']   	  = 'XXXX XXXX XXXX XXXX';
$_['text_cc_date_placeholder'] 		  = 'MM / YY';
$_['text_cc_cvc_placeholder']         = 'XXX';
$_['text_cc_cvc_hint'] = 'what is this?';
$_['text_cc_type']                    = 'Type of card';
$_['text_cc_holder']                  = 'Card holder name';
$_['text_cc_number']                  = 'Card number';
$_['text_cc_expiry_date']             = 'Expiry date';
$_['text_cc_cvc']                     = 'CVC/CVV/CID';
$_['novalnet_cc_payment_details_error']      = 'Your credit card details are invalids';
$_['novalnet_cc_new_card_details']    = 'Add new account details for later purchases';
$_['novalnet_cc_given_card_details']  = 'Given account details';
$_['maestro_logo']                    = '<img class="novalnet_cc_logo" src="image/payment/novalnet/novalnet_maestro.png" alt="Credit Card" title="Credit Card" />';
$_['payment_logo']                    = '<img class="novalnet_cc_logo" src="image/payment/novalnet/novalnet_cc.png" alt="Credit Card" title="Credit Card" />  <img class="novalnet_cc_logo" src="image/payment/novalnet/novalnet_cc_mastercard.png" alt="Credit Card" title="Credit Card" />';
$_['amex_logo']                       = '<img class="novalnet_cc_logo" src="image/payment/novalnet/novalnet_amex.png" alt="Credit Card" title="Credit Card"/>';
$_['zero_amount_desc']                ='<p style=color:red>' .'This order will be processed as zero amount booking which store your payment data for further online purchases.'.'</p>';
$_['save_card_details']                ='Save my card details for future purchases';

