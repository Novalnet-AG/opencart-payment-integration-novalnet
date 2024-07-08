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

$_['text_success']                                     = 'Datensatz erfolgreich bearbeitet';
$_['entry_enable_payment']                             = 'Zahlungsart anzeigen';
$_['enable_test_mode']                                 = 'Testmodus aktivieren';
$_['test_mode_desc']                                   = 'Die Zahlung wird im Testmodus durchgeführt, daher wird der Betrag für diese Transaktion nicht eingezogen.';
$_['notification_buyer']                               = 'Benachrichtigung des Käufers';
$_['notification_buyer_desc']                          = 'Der eingegebene Text wird auf der Checkout-Seite angezeigt.';
$_['slip_expiry_date']                                 = 'Verfallsdatum des Zahlscheins (in Tagen)';
$_['slip_expiry_date_desc']                            = 'Anzahl der Tage, die der Käufer Zeit hat, um den Betrag in einer Filiale zu bezahlen. Wenn Sie dieses Feld leer lassen, ist der Zahlschein standardmäßig 14 Tage lang gültig';
$_['order_completion_status']                          = 'Status für erfolgreichen Auftragsabschluss';
$_['order_completion_status_desc']					   = 'Wählen Sie, welcher Status für erfolgreich abgeschlossene Bestellungen verwendet wird ';
$_['text_true']                                        = 'Wahr';
$_['text_false']                                       = 'Falsch';
$_['entry_minimum_goods']                              = 'Mindestbestellbetrag (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_minimum_goods_desc']                         = 'Mindestbestellsumme zur Anzeige der ausgewählten Zahlungsart(en) im Checkout';
$_['entry_geo_zone']                                   = 'Geografisches Gebiet';
$_['entry_geo_zone_desc']                              = 'Wird ein Bereich ausgewählt, dann wird dieses Modul nur für den ausgewählten Bereich aktiviert';
$_['entry_sort_order']                                 = 'Geben Sie eine Sortierreihenfolge an.';
$_['entry_sort_order_desc']                            = 'Die Zahlungsarten werden in Ihrem Checkout anhand der von Ihnen vorgegebenen Sortierreihenfolge angezeigt (in aufsteigender Reihenfolge)';
$_['login_msg']                                        = 'Loggen Sie sich hier mit Ihren Novalnet-Händlerzugangsdaten ein. Kontaktieren Sie uns bitte unter <a style="color:white;" href="mailto:support@novalnet.de">support@novalnet.de</a>, um Zahlungsarten zu aktivieren.';
$_['text_manage_transaction']                          = 'Transaktion verwalten';
$_['text_manage_transaction_process']                  = 'Ablauf der Buchung steuern';
$_['text_transaction_amount']                          = 'Transaktionsbetrag';
$_['text_refund']                                      = 'Rückerstattung für Transaktion';
$_['text_refund_process']                              = 'Ablauf der Rückerstattung';
$_['text_refund_amount']                               = 'Geben Sie bitte den erstatteten Betrag ein';
$_['text_refund_reference']                            = 'Referenz für die Rückerstattung: ';
$_['text_refund_amount_duedate_change']                = 'Betrag / Fälligkeitsdatum ändern';
$_['text_amount_update']                               = 'Betrag ändern';
$_['text_amount_expiry_date_update']                   = 'Betrag/Verfallsdatum des Zahlscheins ändern';
$_['text_slip_expiry_date']                            = 'Verfallsdatum des Zahlscheins';
$_['text_amount_update_transaction_duedate']           = 'Fälligkeitsdatum der Transaktion';
$_['text_amount_update_with_duedate_message']          = 'Sind Sie sicher, dass Sie den Bestellbetrag / das Fälligkeitsdatum ändern möchten?';
$_['text_amount_update_message']                       = 'Sind Sie sich sicher, dass Sie den Bestellbetrag ändern wollen?';
$_['text_refund_message']                              = 'Sind Sie sicher, dass Sie den Betrag zurückerstatten möchten?';
$_['text_capture_message']                             = 'Sind Sie sicher, dass Sie die Zahlung einziehen möchten?';
$_['text_cancel_message']                              = 'Sind Sie sicher, dass Sie die Zahlung stornieren wollen?';
$_['text_book_message']                                = 'Sind Sie sich sicher, dass Sie den Bestellbetrag buchen wollen?';
$_['text_status_select']                               = 'Wählen Sie bitte einen Status aus';
$_['text_select']                                      = '--Auswählen--';
$_['text_confirm']                                     = 'Zahlung einziehen';
$_['text_cancel']                                      = 'Zahlung autorisieren';
$_['text_update']                                      = 'Aktualisieren';
$_['text_book']                                        = 'Buchen';
$_['text_cents']                                       = ' (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR) ';
$_['text_booking_transaction']                         = 'Transaktion durchführen';
$_['text_booking_transaction_amount']                  = 'Buchungsbetrag der Transaktion';
$_['error_amount_update_duedate_future']               = 'Das Datum sollte in der Zukunft liegen.';
$_['error_amount_update_duedate_invalid']              = 'Ungültiges Fälligkeitsdatum';
$_['error_amount_invalid']                             = 'Ungültiger Betrag';
$_['select_errors']                                    = 'Wählen Sie bitte einen Status aus';
$_['refund_parent_tid_msg1']                           = 'Die Rückerstattung für die TID: ';
$_['refund_parent_tid_msg2']                           = ' mit dem Betrag %s durchgeführt.';
$_['refund_child_tid_msg']                             = ' Ihre neue TID für den erstatteten Betrag: ';
$_['partial_refund_msg']                               = 'Ablauf der Rückerstattung';
$_['text_novalnet_TID']                                = 'Novalnet Transaktions-ID: ';
$_['text_novalnet_test_order']                         = 'Testbestellung';
$_['empty_booking_amount']                             = 'Ungültiger Betrag';
$_['confirm_booking1']                                 = 'Ihre Bestellung wurde mit einem Betrag von ';
$_['confirm_booking2']                                 = 'gebucht. Ihre neue TID für den gebuchten Betrag: ';
$_['message_amount_update1']                           = 'Die Transaktion wurde mit dem Betrag ';
$_['message_amount_update2']                           = 'und dem Fälligkeitsdatum %s aktualisiert.';
$_['message_amount_update3']                           = 'neues Fälligkeitsdatum des Zahlscheins: %s.';
$_['sepa_amount_update1']                              = 'Transaktionsbetrag ';
$_['sepa_amount_update2']                              = 'wurde am %s um %s Uhr erfolgreich geändert';
$_['text_transaction_confirm']                         = 'Die Buchung wurde am %s um %s Uhr bestätigt.';
$_['text_amount_update_with_exipry_message']           = 'Sind Sie sicher, dass sie den Bestellbetrag / das Ablaufdatum des Zahlscheins ändern wollen?';
$_['text_transaction_cancel']                          = 'Die Transaktion wurde am %s um %s Uhr storniert';
$_['text_transaction_details']                         = 'Novalnet-Transaktionsdetails';
$_['text_guarantee_payment_configuration']             = 'Einstellungen für die Zahlungsgarantie';
$_['text_guarantee_payment_requirements']              = 'Grundanforderungen für die Zahlungsgarantie';
$_['text_guarantee_payment_requirements_1']            = 'Zugelassene Staaten: AT, DE, CH';
$_['text_guarantee_payment_requirements_2']            = 'Zugelassene Währung: EUR';
$_['text_guarantee_payment_requirements_3']            = 'Mindestbetrag der Bestellung: 9,99 EUR';
$_['text_guarantee_payment_requirements_4']            = 'Mindestalter: 18 Jahre';
$_['text_guarantee_payment_requirements_5']            = 'Rechnungsadresse und Lieferadresse müssen übereinstimmen';
$_['text_guarantee_payment_enable']                    = 'Zahlungsgarantie aktivieren';
$_['text_guarantee_payment_minimum_order_amount']      = 'Mindestbestellbetrag für Zahlungsgarantie (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['text_guarantee_payment_minimum_order_amount_desc'] = 'Geben Sie den Mindestbetrag (in Cent) für die zu bearbeitende Transaktion mit Zahlungsgarantie ein. Geben Sie z.B. 100 ein, was 1,00 entspricht. Der Standbetrag ist 9,99 EUR.';
$_['text_guarantee_payment_force']                     = 'Zahlung ohne Zahlungsgarantie erzwingen';
$_['text_guarantee_payment_force_desc']                = 'Falls die Zahlungsgarantie zwar aktiviert ist, jedoch die Voraussetzungen für Zahlungsgarantie nicht erfüllt sind, wird die Zahlung ohne Zahlungsgarantie verarbeitet. ';
$_['text_guarantee_payment_minimum_error']             = 'Diese Einstellung überschreibt die Standardeinstellung für den Mindest-Bestellbetrag. Anmerkung: der Mindest-Bestellbetrag sollte größer oder gleich 9,99 EUR sein.';
$_['text_novalnet_comments']                           = 'Bitte überweisen Sie den Betrag auf das unten stehende Konto.';
$_['text_novalnet_account_holder']                     = 'Kontoinhaber: ';
$_['text_novalnet_due_date']                           = 'Fälligkeitsdatum: ';
$_['text_novalnet_bank']                               = 'Bank: ';
$_['text_novalnet_iban']                               = 'IBAN: ';
$_['text_novalnet_bic']                                = 'BIC: ';
$_['text_novalnet_amount']                             = 'Betrag: ';
$_['text_novalnet_order_no']                           = 'Bestellnummer ';
$_['text_novalnet_reference']                          = 'Verwendungszweck';
$_['text_novalnet_reference_any_one']                  = 'Bitte verwenden Sie einen der unten angegebenen Verwendungszwecke für die Überweisung. Nur so kann Ihr Geldeingang Ihrer Bestellung zugeordnet werden: ';
$_['shopping_type']                                    = 'Einkaufstyp';
$_['shopping_type_desc']                               = 'Einkaufstyp auswählen';
$_['shopping_type_none']                               = 'Keiner';
$_['one_click_shopping']                               = 'Kauf mit einem Klick';
$_['zero_amount_booking']                              = 'Transaktionen mit Betrag 0';
$_['callback_order_status']                            = 'Callback-Bestellstatus';
$_['callback_order_status_desc']					   = 'Status, der zu verwendet wird, wenn das Callback-Skript für eine bei Novalnet eingegangene Zahlung ausgeführt wird ';
$_['text_recurring_cancel']                            = 'Recurring order cancelled.';
$_['text_next_charging_date']                          = 'Nächstes Belastungsdatum: ';
$_['button_subscription_cancel']                       = 'Abonnement kündigen';
$_['text_recurring_orders']                            = 'Novalnet-Bestellungen';
$_['text_payment']                                     = 'Zahlarten';
$_['text_extension']                                   = 'Erweiterungen';
$_['text_novalnet_paypal_title']                       = 'PayPal';
$_['guarantee_payment_pending_status']                 = 'Status für Bestellungen mit ausstehender Zahlung';
$_['guarantee_payment_pending_status_desc']				='Wählen Sie, welcher Status für Bestellungen mit ausstehender Zahlung verwendet wird';
$_['entry_onhold_limit']                      		   = 'Mindesttransaktionsbetrag für die Autorisierung (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_onhold_limit_desc']                 		   = 'Übersteigt der Bestellbetrag das genannte Limit, wird die Transaktion, bis zu ihrer Bestätigung durch Sie, auf on hold gesetzt. Sie können das Feld leer lassen, wenn Sie möchten, dass alle Transaktionen als on hold behandelt werden.';
$_['text_invoice_transaction_confirm']				   = 'Die Transaktion mit der TID: %s wurde erfolgreich bestätigt und das Fälligkeitsdatum auf %s gesetzt.';
$_['text_novalnet_invoice_title']                      = 'Kauf auf Rechnung';
$_['text_novalnet_sepa_title']                      = 'SEPA-Lastschrift';
$_['text_novalnet_cc_title']                      = 'Kredit- / Debitkarte';
$_['text_novalnet_paypal_title']                      = ' PayPal';
$_['text_guarantee_payment']          = 'Diese Transaktion wird mit Zahlungsgarantie verarbeitet';
