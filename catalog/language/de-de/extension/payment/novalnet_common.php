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
$_['text_test_mode_description']                   = '<span style="color:red;">Die Zahlung wird im Testmodus durchgeführt, daher wird der Betrag für diese Transaktion nicht eingezogen.</span>';
$_['text_novalnet_TID']                            = 'Novalnet Transaktions-ID: ';
$_['text_novalnet_test_order']                     = 'Testbestellung';
$_['text_novalnet_automaticredirection']           = 'Nach der erfolgreichen Überprüfung werden Sie auf die abgesicherte Novalnet-Bestellseite umgeleitet, um die Zahlung fortzusetzen.';
$_['text_wait']                                    = 'Please wait...';
$_['text_order_processed']                         = 'Warten Sie bitte, Ihre Bestellung wird vearbeitet.';
$_['error_check_hash']                             = 'Während der Umleitung wurden einige Daten geändert. Die Überprüfung des Hashes schlug fehl';
$_['text_redirect']                                = 'Sie werden zum Shop weitergeleitet. Bitte warten Sie.';
$_['text_browser_description']                     = 'Bitte schließen Sie den Browser nach der erfolgreichen Zahlung nicht, bis Sie zum Shop zurückgeleitet wurden.';
$_['text_payment_description']                     = 'Nach der erfolgreichen Überprüfung werden Sie auf die abgesicherte Novalnet-Bestellseite umgeleitet, um die Zahlung fortzusetzen.';
$_['text_barzahlen_payment_description']           = 'Nach erfolgreichem Bestellabschluss erhalten Sie einen Zahlschein bzw. eine SMS. Damit können Sie Ihre Online-Bestellung bei einem unserer Partner im Einzelhandel (z.B. Drogerie, Supermarkt etc.)';
$_['error_order_amount_changed']                   = 'Der Bestellbetrag hat sich geändert, setzen Sie bitte die neue Bestellung fort.';
$_['text_guarantee_payment_dob']                   = 'Ihr Geburtsdatum';
$_['error_dob_empty']                              = 'Geben Sie bitte Ihr Geburtsdatum ein';
$_['error_dob_invalid_format']                     = 'Ungültiges Datumsformat';
$_['error_sepa_age_below_18']                      = 'Sie müssen mindestens 18 Jahre alt sein.';
$_['error_guarantee_billing_shipping_address']     = '<span style="color:red;"><li>Rechnungsadresse und Lieferadresse müssen übereinstimmen</li></span>';
$_['error_guarantee_currency']     				   = '<span style="color:red;"><li>Als Währung ist nur EUR erlaubt</li></span>';
$_['error_guarantee_minimum_amount'] 		       = '<span style="color:red;"><li>Der Mindestbestellwert beträgt </span>';
$_['error_eur'] 		       					   = '<span style="color:red;"> EUR</li></span>';
$_['error_guarantee_country']     				   = '<span style="color:red;"><li>Als Land ist nur Deutschland, Österreich oder Schweiz erlaubt</li></span>';
$_['error_telephone_empty']                        = 'Geben Sie bitte Ihre Telefonnummer ein';
$_['error_mobile_empty']                           = 'Geben Sie bitte Ihre Mobiltelefonnummer ein';
$_['text_payment_reference']                       = 'Verwendungszweck';
$_['text_payment_reference_any_one']               = 'Bitte verwenden Sie einen der unten angegebenen Verwendungszwecke für die Überweisung, da nur so Ihr Geldeingang zugeordnet werden kann: ';
$_['text_payment_reference_only']                  = 'Bitte verwenden Sie nur den unten angegebenen Verwendungszweck für die Überweisung, da nur so Ihr Geldeingang zugeordnet werden kann: ';
$_['text_guarantee_payment_reference_transaction'] = 'Sobald die Bestellung abgeschickt wurde, wird die Zahlung bei Novalnet als Referenztransaktion verarbeitet.';
$_['text_trial']                                   = '%s every %s %s for %s payments then ';
$_['text_recurring']                               = '%s every %s %s';
$_['text_recurring_item']                          = 'Recurring Item';
$_['text_length']                                  = ' for %s payments';
$_['text_test_order_notification']                 = 'ehr geehrte Kundin, %s wir möchten Sie darüber informieren, dass eine Testbestellung %s kürzlich in Ihrem Shop durchgeführt wurde. Stellen Sie bitte sicher, dass für Ihr Projekt im Novalnet-Administrationsportal der Live-Modus gesetzt wurde und Zahlungen über Novalnet in Ihrem Shopsystem aktiviert sind. Ignorieren Sie bitte diese E-Mail, falls die Bestellung von Ihnen zu Testzwecken durchgeführt wurde.%sMit freundlichen Grüßen %sNovalnet AG';
$_['text_test_order_notification_subject']         = 'Benachrichtigung zu Novalnet-Testbestellung - OPENCART';
$_['text_guarantee_payment']          = 'Diese Transaktion wird mit Zahlungsgarantie verarbeitet';
$_['text_novalnet_bank_comments']       = 'Überweisen Sie bitte den Betrag an die unten aufgeführte Bankverbindung unseres Zahlungsdienstleisters Novalnet.';
$_['text_novalnet_account_holder'] = 'Kontoinhaber: ';
$_['text_novalnet_due_date']       = 'Fälligkeitsdatum: ';
$_['text_novalnet_slip_expiry_date']  = 'Verfallsdatum des Zahlscheins: ';
$_['text_nearest_store_details']      = 'Barzahlen-Partnerfiliale in Ihrer Nähe';
$_['text_novalnet_bank']           = 'Bank:  ';
$_['text_novalnet_iban']           = 'IBAN:  ';
$_['text_novalnet_bic']            = 'BIC: ';
$_['text_novalnet_amount']         = 'Betrag: ';
$_['text_novalnet_order_no']       = 'Bestellnummer ';
$_['text_guarantee_payment_warning_msg']   = '<span style="color:red;">Die Zahlung kann nicht verarbeitet werden, weil die grundlegenden Anforderungen nicht erfüllt wurden.</span>';
$_['text_recurring_cancel']   = 'Profil für wiederkehrende Zahlungen wurde storniert';
$_['text_next_charging_date']   = 'Nächstes Belastungsdatum: ';
$_['button_subscription_cancel']   = 'Abonnement kündigen';
$_['text_recurring_orders']   = 'Novalnet-Bestellungen';
$_['text_transaction_details']                   = 'Novalnet-Transaktionsdetails';
$_['text_recurring_date_not_met']         = 'Das nächste Buchungsdatum stimmt nicht mit dem nächsten Zahlungsdatum überein';
$_['text_recurring_profile_canceled']     = 'Profil für wiederkehrende Zahlungen wurde storniert';
$_['text_recurring_request_parameters']   = 'Parameter für den Aufruf des Servers im Profil für wiederkehrende Zahlungen';
$_['text_recurring_response_parameters']  = 'Parameter für die Rückmeldung des Servers im Profil für wiederkehrende Zahlungen';
$_['error_payment_not_successful']  = 'Die Zahlung war nicht erfolgreich. Ein Fehler trat auf.';
$_['text_guarantee_pending_text'] = '<br> Ihre Bestellung ist unter Bearbeitung. Sobald diese bestätigt wurde, erhalten Sie alle notwendigen Informationen zum Ausgleich der Rechnung. Wir bitten Sie zu beachten, dass dieser Vorgang bis zu 24 Stunden andauern kann. <br>';
$_['text_guarantee_pending_sepa_text'] = '<br> Ihre Bestellung wird derzeit überprüft. Wir werden Sie in Kürze über den Bestellstatus informieren. Bitte beachten Sie, dass dies bis zu 24 Stunden dauern kann. <br>';
