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
 * Script : novalnet_common.php
 *
 */
$_['text_test_mode_description']                   = '<span style="color:red;">The payment will be processed in the test mode therefore amount for this transaction will not be charged</span>';
$_['text_novalnet_TID']                            = 'Novalnet transaction ID: ';
$_['text_novalnet_test_order']                     = 'Test order';
$_['text_wait']                                    = 'Please wait...';
$_['text_order_processed']                         = 'Please wait, your order is being processed';
$_['error_check_hash']                             = 'While redirecting some data has been changed. The hash check failed.';
$_['text_redirect']                                = 'You will be redirected to the shop. Please wait';
$_['text_barzahlen_payment_description']           = 'On successful checkout, you will receive a payment slip/SMS to pay your online purchase at one of our retail partners (e.g. supermarket).';
$_['error_order_amount_changed']                   = 'The order amount has been changed, please proceed with the new order';
$_['text_guarantee_payment_dob']                   = 'Your date of birth';
$_['error_dob_empty']                              = 'Please enter your date of birth';
$_['error_dob_invalid_format']                     = 'The date format is invalid';
$_['error_sepa_age_below_18']                      = 'You need to be at least 18 years old';
$_['error_guarantee_billing_shipping_address']     = '<span style="color:red;"><li>The billing address must be the same as the shipping address</li></span>';
$_['error_guarantee_currency']     				   = '<span style="color:red;"><li>Only EUR currency allowed</li></span>';
$_['error_guarantee_minimum_amount'] 		       = '<span style="color:red;"><li>Minimum order amount must be </span>';
$_['error_eur'] 		       					   = '<span style="color:red;"> EUR</li></span>';
$_['error_guarantee_country']     				   = '<span style="color:red;"><li>Only DE, CH countries allowed</li></span>';
$_['error_callback_empty']                         = 'Please enter your telephone number';
$_['error_sms_empty']                              = 'Please enter your mobile number';
$_['text_payment_reference']                       = 'Payment Reference';
$_['text_payment_reference_any_one']               = 'Please use any one of the following references as the payment reference, as only through this way your payment is matched and assigned to the order: ';
$_['text_payment_reference_only']                  = 'Please use the following payment reference for your money transfer, as only through this way your payment is matched and assigned to the order: ';
$_['text_guarantee_payment_reference_transaction'] = 'Once the order is submitted, the payment will be processed as a reference transaction at Novalnet';
$_['text_trial']                                   = '%s every %s %s for %s payments then ';
$_['text_recurring']                               = '%s every %s %s';
$_['text_recurring_item']                          = 'Recurring Item';
$_['text_length']                                  = ' for %s payments';
$_['text_test_order_notification']                 = 'Dear client, %sWe would like to inform you that test order %s has been placed in your shop recently.Please make sure your project is in LIVE mode at Novalnet administration portal and Novalnet payments are enabled in your shop system. Please ignore this email if the order has been placed by you for testing purpose.%sRegards,%sNovalnet AG';
$_['text_test_order_notification_subject']         = 'Novalnet test order notification - OPENCART';
$_['text_novalnet_bank_comments']          = 'Please transfer the amount to the below mentioned account details of our payment processor Novalnet';
$_['text_guarantee_payment']          = '<b>This is processed as a guarantee payment</b>';
$_['text_novalnet_account_holder']    = 'Account holder: ';
$_['text_novalnet_due_date']          = 'Due date: ';
$_['text_novalnet_slip_expiry_date']  = 'Slip expiry date: ';
$_['text_nearest_store_details']      = 'Store(s) near you';
$_['text_novalnet_bank']              = 'Bank: ';
$_['text_novalnet_iban']              = 'IBAN:  ';
$_['text_novalnet_bic']               = 'BIC:  ';
$_['text_novalnet_amount']            = 'Amount: ';
$_['text_novalnet_order_no']          = 'Order number ';
$_['text_guarantee_payment_warning_msg']   = '<span style="color:red;">The payment cannot be processed, because the basic requirements haven’t been met.</span>';
$_['text_recurring_cancel']   = 'Recurring order canceled.';
$_['text_next_charging_date']   = 'Next charging date: ';
$_['button_subscription_cancel']   = 'Cancel Subscription';
$_['text_recurring_orders']   = 'Novalnet Orders';
$_['text_transaction_details']                   = 'Novalnet transaction details';
$_['text_recurring_date_not_met']         = 'Recurring date does not meet the next payment date';
$_['text_recurring_profile_canceled']     = 'Recurring profile canceled';
$_['text_recurring_request_parameters']   = 'Recurring profile server request parameters';
$_['text_recurring_response_parameters']  = 'Recurring profile server response parameters';
$_['error_payment_not_successful']  = 'Payment was not successful. An error occurred.';
$_['text_guarantee_pending_text'] = '<br> Your order is under verification and once confirmed, we will send you our bank details to where the order amount should be transferred. Please note that this may take upto 24 hours.<br>';
$_['text_guarantee_pending_sepa_text'] = '<br> Your order is under verification and we will soon update you with the order status. Please note that this may take upto 24 hours.<br>';
