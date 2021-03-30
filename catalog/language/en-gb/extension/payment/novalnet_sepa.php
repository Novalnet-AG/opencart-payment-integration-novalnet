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
 * Script : novalnet_sepa.php
 */
include(DIR_LANGUAGE . 'en-gb/extension/payment/novalnet_common.php');
$_['text_title'] = $_['text_novalnet_sepa_title'] = 'Direct Debit SEPA';
$_['text_payment_description']           = 'Your account will be debited upon the order submission';
$_['text_sepa_account_holder']           = 'Account holder';
$_['text_sepa_account_no']               = 'IBAN';
$_['text_sepa_mandate_confirmation']     = 'I hereby grant the mandate for the SEPA direct debit (electronic transmission) and confirm that the given bank details are correct. ';
$_['text_sepa_mandate_confirmation_desc']     = 'I authorise (A) Novalnet AG to send instructions to my bank to debit my account and (B) my bank to debit my account in accordance with the instructions from Novalnet AG.
					<br>
					<br>
					<strong>Creditor identifier: DE53ZZZ00000004253</strong>
					<br>
					<br>
					<strong>Note:</strong> You are entitled to a refund from your bank under the terms and conditions of your agreement with bank. A refund must be claimed within 8 weeks starting from the date on which your account was debited.';
$_['novalnet_sepa_payment_details_error'] = 'Your account details are invalid';
$_['error_sepa_mandate']                 = 'Please accept the SEPA direct debit mandate';
$_['error_sepa_due_date']                = 'SEPA Due date is not valid';
$_['novalnet_sepa_new_account_details']     = 'Enter new account details';
$_['novalnet_sepa_given_account_details']   = 'Given account details';
$_['payment_logo']                          = '<img id="novalnet_sepa_logo" src="image/payment/novalnet/novalnet_sepa.png" alt="Direct Debit SEPA" title="Direct Debit SEPA" style="width:46px; height:14px;"/>';
$_['zero_amount_desc']                      ='<p style=color:red>' .'This order will be processed as zero amount booking which store your payment data for further online purchases.'.'</p>';
$_['save_card_details']               		='Save my account details for future purchases';
