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
 */

$_['entry_enable_payment']                             = 'Display payment method';
$_['enable_test_mode']                                 = 'Enable test mode';
$_['test_mode_desc']                                   = 'The payment will be processed in the test mode therefore amount for this transaction will not be charged';
$_['zero_amount_desc']                                 = 'This order will be processed as zero amount booking which store your payment data for further online purchases';
$_['notification_buyer']                               = 'Notification for the buyer';
$_['notification_buyer_desc']                          = 'The entered text will be displayed on the checkout page';
$_['slip_expiry_date']                                 = 'Slip expiry date (in days)';
$_['slip_expiry_date_desc']                            = 'Number of days given to the buyer to pay at a store. If this field is left blank, 14 days will be set as slip expiry date by default';
$_['order_completion_status']                          = 'Completed order status';
$_['order_completion_status_desc']					   = 'Status to be used for successful orders.';
$_['text_true']                                        = 'True';
$_['text_false']                                       = 'False';
$_['entry_minimum_goods']                              = 'Minimum order amount (in minimum unit of currency. E.g. enter 100 which is equal to 1.00)';
$_['entry_minimum_goods_desc']                         = 'Minimum order amount to display the selected payment method (s) at during checkout';
$_['entry_geo_zone']                                   = 'Geo Zones';
$_['entry_geo_zone_desc']                              = 'If a zone is selected then this module is activated only for Selected zone.';
$_['entry_sort_order']                                 = 'Define a sorting order';
$_['entry_sort_order_desc']                            = 'The payment methods will be listed in your checkout (in ascending order) based on your given sorting order';
$_['login_msg']                                        = 'Please login here with Novalnet merchant credentials. Please contact us on <a style="color:white;" href="mailto:support@novalnet.de">support@novalnet.de</a> for activating payment methods!';
$_['text_manage_transaction']                          = 'Manage transaction';
$_['text_manage_transaction_process']                  = 'Manage transaction process';
$_['text_transaction_amount']                          = 'Transaction amount';
$_['text_refund']                                      = 'Transaction refund';
$_['text_refund_process']                              = 'Refund process';
$_['text_refund_amount']                               = 'Please enter the refund amount:';
$_['text_refund_reference']                            = 'Refund reference: ';
$_['text_refund_amount_duedate_change']                = 'Change the amount / due date';
$_['text_amount_update']                               = 'Amount update';
$_['text_amount_expiry_date_update']                   = 'Change the amount/slip expiry date';
$_['text_slip_expiry_date']                            = 'Slip expiry date';
$_['text_amount_update_transaction_duedate']           = 'Transaction due date';
$_['text_amount_update_with_duedate_message']          = 'Are you sure you want to change the order amount / due date?';
$_['text_amount_update_message']                       = 'Are you sure you want to change the order amount?';
$_['text_refund_message']                              = 'Are you sure you want to refund the amount?';
$_['text_capture_message']                             = 'Are you sure you want to capture the payment?';
$_['text_cancel_message']                              = 'Are you sure you want to cancel the payment?';
$_['text_book_message']                                = 'Are you sure you want to book the order amount?';
$_['text_status_select']                               = 'Please select status';
$_['text_select']                                      = 'Select';
$_['text_confirm']                                     = 'confirm';
$_['text_cancel']                                      = 'cancel';
$_['text_update']                                      = 'Update';
$_['text_book']                                        = 'Book';
$_['text_cents']                                       = ' (in minimum unit of currency. E.g. enter 100 which is equal to 1.00) ';
$_['text_booking_transaction']                         = 'Book transaction';
$_['text_booking_transaction_amount']                  = 'Transaction booking amount';
$_['error_amount_update_duedate_future']               = 'The date should be in future';
$_['error_amount_update_duedate_invalid']              = 'Invalid due date';
$_['error_amount_invalid']                             = 'The amount is invalid';
$_['select_errors']                                    = 'Please select status';
$_['refund_parent_tid_msg1']                           = 'Refund has been initiated for the TID: ';
$_['refund_parent_tid_msg2']                           = ' with the amount %s.';
$_['refund_child_tid_msg']                             = ' Your new TID for the refund amount:';
$_['partial_refund_msg']                               = 'Refund Process';
$_['text_novalnet_TID']                                = 'Novalnet transaction ID: ';
$_['text_novalnet_test_order']                         = 'Test order';
$_['empty_booking_amount']                             = 'The amount is invalid';
$_['confirm_booking1']                                 = 'Your order has been booked with the amount of ';
$_['confirm_booking2']                                 = '. Your new TID for the booked amount ';
$_['message_amount_update1']                           = 'The transaction has been updated with amount ';
$_['message_amount_update2']                           = 'and due date %s';
$_['message_amount_update3']                           = 'and slip expiry date %s';
$_['text_amount_update_with_exipry_message']           = 'Are you sure you want to change the order amount / slip expiry date?';
$_['sepa_amount_update1']                              = 'Transaction amount ';
$_['sepa_amount_update2']                              = 'has been updated successfully on %s %s';
$_['text_transaction_confirm']                         = 'The transaction has been confirmed on %s %s';
$_['text_transaction_cancel']                          = 'The transaction has been canceled on %s %s';
$_['text_transaction_details']                         = 'Novalnet transaction details';
$_['text_guarantee_payment_configuration']             = 'Payment guarantee configuration';
$_['text_guarantee_payment_requirements']              = 'Basic requirements for payment guarantee';
$_['text_guarantee_payment_requirements_1']            = 'Allowed countries: AT, DE, CH';
$_['text_guarantee_payment_requirements_2']            = 'Allowed currency: EUR';
$_['text_guarantee_payment_requirements_3']            = 'Minimum order amount: 9,99 EUR or more';
$_['text_guarantee_payment_requirements_4']            = 'Age limit: 18 years or more';
$_['text_guarantee_payment_requirements_5']            = 'The billing address must be the same as the shipping address';
$_['text_guarantee_payment_enable']                    = 'Enable payment guarantee';
$_['text_guarantee_payment_minimum_order_amount']      = 'Minimum order amount for payment guarantee (in minimum unit of currency. E.g. enter 100 which is equal to 1.00)';
$_['text_guarantee_payment_minimum_order_amount_desc'] = 'Enter the minimum amount (in cents) for the transaction to be processed with payment guarantee. For example, enter 100 which is equal to 1,00. By default, the amount will be 9,99 EUR.';
$_['text_guarantee_payment_force']                     = 'Force Non-Guarantee payment';
$_['text_guarantee_payment_force_desc']                = 'Even if payment guarantee is enabled, payments will still be processed as non-guarantee payments if the payment guarantee requirements are not met.';
$_['text_guarantee_payment_minimum_error']             = 'This setting will override the default setting made in the minimum order amount. Note: Minimum amount should be greater than or equal to 9,99 EUR';
$_['text_novalnet_comments']                           = 'Please transfer the amount to the below mentioned account.';
$_['text_novalnet_account_holder']                     = 'Account holder: ';
$_['text_novalnet_due_date']                           = 'Due date: ';
$_['text_novalnet_bank']                               = 'Bank: ';
$_['text_novalnet_iban']                               = 'IBAN: ';
$_['text_novalnet_bic']                                = 'BIC: ';
$_['text_novalnet_amount']                             = 'Amount: ';
$_['text_novalnet_order_no']                           = 'Order number ';
$_['text_novalnet_reference']                          = 'Payment Reference';
$_['text_novalnet_reference_any_one']                  = 'Please use any of the following payment references when transferring the amount. This is necessary to match it with your corresponding order:';
$_['shopping_type']                                    = 'Shopping type';
$_['shopping_type_desc']                               = 'Select shopping type';
$_['shopping_type_none']                               = 'None';
$_['one_click_shopping']                               = 'One-click shopping';
$_['zero_amount_booking']                              = 'Zero amount booking';
$_['callback_order_status']                            = 'Callback order status';
$_['callback_order_status_desc']					   = 'Status to be used when callback script is executed for payment received by Novalnet';
$_['text_recurring_cancel']                            = 'Recurring order cancelled.';
$_['text_next_charging_date']                          = 'Next charging date: ';
$_['button_subscription_cancel']                       = 'Cancel Subscription';
$_['text_recurring_orders']                            = 'Novalnet Orders';
$_['text_payment']                                     = 'Payment';
$_['text_extension']                                   = 'Extensions';
$_['text_novalnet_paypal_title']                       = 'PayPal';
$_['guarantee_payment_pending_status']                 = 'Payment pending order status';
$_['guarantee_payment_pending_status_desc']				 = 'Status to be used for pending transactions. ';
$_['entry_onhold_limit']                      		   = 'Minimum transaction amount for authorization (in minimum unit of currency. E.g. enter 100 which is equal to 1.00)';
$_['entry_onhold_limit_desc']                 		   = 'In case the order amount exceeds the mentioned limit, the transaction will be set on-hold till your confirmation of the transaction. You can leave the field empty if you wish to process all the transactions as on-hold.';
$_['text_invoice_transaction_confirm']				   = 'The transaction has been confirmed successfully for the TID: %s and the due date updated as %s';
$_['text_novalnet_invoice_title']                      = 'Invoice';
$_['text_novalnet_sepa_title']                      = 'Direct Debit SEPA';
$_['text_novalnet_cc_title']                      = 'Credit/Debit Cards';
$_['text_novalnet_paypal_title']                      = ' PayPal';
$_['text_guarantee_payment']          = '<b>This is processed as a guarantee payment</b>';
