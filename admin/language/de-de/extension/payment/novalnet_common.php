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
$_['entry_enable_payment']                             = 'Zahlungsart aktivieren';
$_['enable_test_mode']                                 = 'Testmodus aktivieren';
$_['test_mode_desc']                                   = 'Die Zahlung wird im Testmodus durchgeführt, daher wird der Betrag für diese Transaktion nicht eingezogen.';
$_['notification_buyer']                               = 'Benachrichtigung des Käufers';
$_['notification_buyer_desc']                          = 'Der eingegebene Text wird auf der Checkout-Seite angezeigt.';
$_['slip_expiry_date']                                 = 'Verfallsdatum des Zahlscheins (in Tagen)';
$_['slip_expiry_date_desc']                            = 'Geben Sie die Anzahl der Tage ein, um den Betrag in einer Barzahlen-Partnerfiliale in Ihrer Nähe zu bezahlen. Wenn das Feld leer ist, werden standardmäßig 14 Tage als Fälligkeitsdatum gesetzt.';
$_['order_completion_status']                          = 'Abschluss-Status der Bestellung';
$_['text_true']                                        = 'Wahr';
$_['text_false']                                       = 'Falsch';
$_['entry_minimum_goods']                              = 'Mindestwarenwert (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_minimum_goods_desc']                         = 'Geben Sie den Mindestwarenwert ein, von dem ab die Zahlungsart für den Kunden beim Checkout angezeigt wird.';
$_['entry_geo_zone']                                   = 'Geografisches Gebiet';
$_['entry_geo_zone_desc']                              = 'Wird ein Bereich ausgewählt, dann wird dieses Modul nur für den ausgewählten Bereich aktiviert';
$_['entry_sort_order']                                 = 'Geben Sie eine Sortierreihenfolge an.';
$_['entry_sort_order_desc']                            = 'Diese Zahlungsart wird unter anderen Zahlungsarten (in aufsteigender Richtung) anhand der angegebenen Nummer für die Sortierung eingeordnet.';
$_['login_msg']                                        = 'Loggen Sie sich hier mit Ihren Novalnet-Händlerzugangsdaten ein. Kontaktieren Sie uns bitte unter <a style="color:white;" href="mailto:support@novalnet.de">support@novalnet.de</a>, um Zahlungsarten zu aktivieren.';
$_['text_manage_transaction']                          = 'Transaktion verwalten';
$_['text_manage_transaction_process']                  = 'Ablauf der Buchung steuern';
$_['text_transaction_amount']                          = 'Transaktionsbetrag';
$_['text_refund']                                      = 'Rückerstattung';
$_['text_refund_process']                              = 'Ablauf der Rückerstattung';
$_['text_refund_amount']                               = 'Geben Sie bitte den erstatteten Betrag ein';
$_['text_refund_reference']                            = 'Referenz für die Rückerstattung: ';
$_['text_refund_amount_duedate_change']                = 'Betrag / Fälligkeitsdatum ändern';
$_['text_amount_update']                               = 'Betrag ändern';
$_['text_amount_expiry_date_update']                   = 'Betrag/Verfallsdatum des Zahlscheins ändern';
$_['text_slip_expiry_date']                            = 'Verfallsdatum des Zahlscheins';
$_['text_amount_update_transaction_duedate']           = 'Fälligkeitsdatum der Transaktion';
$_['text_amount_update_with_duedate_message']          = 'Sind Sie sich sicher, dass Sie den Betrag / das Fälligkeitsdatum der Bestellung ändern wollen?';
$_['text_amount_update_message']                       = 'Sind Sie sich sicher, dass Sie den Bestellbetrag ändern wollen?';
$_['text_refund_message']                              = 'Sind Sie sicher, dass Sie den Betrag zurückerstatten möchten?';
$_['text_capture_message']                             = 'Sind Sie sicher, dass Sie die Zahlung einziehen möchten?';
$_['text_cancel_message']                              = 'Sind Sie sicher, dass Sie die Zahlung stornieren wollen?';
$_['text_book_message']                                = 'Sind Sie sich sicher, dass Sie den Bestellbetrag buchen wollen?';
$_['text_status_select']                               = 'Wählen Sie bitte einen Status aus';
$_['text_select']                                      = '--Auswählen--';
$_['text_confirm']                                     = 'Bestätigen';
$_['text_cancel']                                      = 'Stornieren';
$_['text_update']                                      = 'Aktualisieren';
$_['text_book']                                        = 'Buchen';
$_['text_cents']                                       = ' (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR) ';
$_['text_booking_transaction']                         = 'Transaktion durchführen';
$_['text_booking_transaction_amount']                  = 'Buchungsbetrag der Transaktion';
$_['error_amount_update_duedate_future']               = 'Das Datum sollte in der Zukunft liegen.';
$_['error_amount_update_duedate_invalid']              = 'Ungültiges Fälligkeitsdatum';
$_['error_amount_invalid']                             = 'Ungültiger Betrag';
$_['select_errors']                                    = 'Wählen Sie bitte einen Status aus';
$_['refund_parent_tid_msg1']                           = 'Die Rückerstattung wurde für die TID: ';
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
$_['message_amount_update3']                           = 'und das Ablaufdatum des Belegs mit %s.';
$_['sepa_amount_update1']                              = 'Der Betrag der Transaktion ';
$_['sepa_amount_update2']                              = 'wurde am %s um %s Uhr erfolgreich geändert';
$_['text_transaction_confirm']                         = 'Die Buchung wurde am %s um %s Uhr bestätigt.';
$_['text_amount_update_with_exipry_message']           = 'Sind Sie sicher, dass sie den Bestellbetrag / das Ablaufdatum des Zahlscheins ändern wollen?';
$_['text_transaction_cancel']                          = 'Die Transaktion wurde am %s um %s Uhr storniert';
$_['text_transaction_details']                         = 'Novalnet-Transaktionsdetails';
$_['text_guarantee_payment_configuration']             = 'Einstellungen für die Zahlungsgarantie';
$_['text_guarantee_payment_requirements']              = 'Grundanforderungen für die Zahlungsgarantie';
$_['text_guarantee_payment_requirements_1']            = 'Zugelassene Staaten: AT, DE, CH';
$_['text_guarantee_payment_requirements_2']            = 'Zugelassene Währung: EUR';
$_['text_guarantee_payment_requirements_3']            = 'Mindestbetrag der Bestellung >= 9,99 EUR';
$_['text_guarantee_payment_requirements_4']            = 'Mindestalter des Endkunden >= 18 Jahre';
$_['text_guarantee_payment_requirements_5']            = 'Rechnungsadresse und Lieferadresse müssen übereinstimmen';
$_['text_guarantee_payment_requirements_6']            = 'Geschenkgutscheine / Coupons sind nicht erlaubt';
$_['text_guarantee_payment_enable']                    = 'Zahlungsgarantie aktivieren';
$_['text_guarantee_payment_minimum_order_amount']      = 'Mindestbestellbetrag (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['text_guarantee_payment_minimum_order_amount_desc'] = 'Diese Einstellung überschreibt die Standardeinstellung für den Mindest-Bestellbetrag. Anmerkung: der Mindest-Bestellbetrag sollte größer oder gleich 9,99 EUR sein.';
$_['text_guarantee_payment_force']                     = 'Zahlung ohne Zahlungsgarantie erzwingen';
$_['text_guarantee_payment_force_desc']                = 'Falls die Zahlungsgarantie aktiviert ist (wahr), die oben genannten Anforderungen jedoch nicht erfüllt werden, soll die Zahlung ohne Zahlungsgarantie verarbeitet werden.';
$_['text_guarantee_payment_minimum_error']             = 'Diese Einstellung überschreibt die Standardeinstellung für den Mindest-Bestellbetrag. Anmerkung: der Mindest-Bestellbetrag sollte größer oder gleich 9,99 EUR sein.';
$_['text_novalnet_comments']                           = 'Überweisen Sie bitte den Betrag an die unten aufgeführte Bankverbindung unseres Zahlungsdienstleisters Novalnet.';
$_['text_novalnet_account_holder']                     = 'Kontoinhaber: ';
$_['text_novalnet_due_date']                           = 'Fälligkeitsdatum: ';
$_['text_novalnet_bank']                               = 'Bank: ';
$_['text_novalnet_iban']                               = 'IBAN: ';
$_['text_novalnet_bic']                                = 'BIC: ';
$_['text_novalnet_amount']                             = 'Betrag: ';
$_['text_novalnet_order_no']                           = 'Bestellnummer ';
$_['text_novalnet_reference']                          = 'Verwendungszweck';
$_['text_novalnet_reference_any_one']                  = 'Bitte verwenden Sie einen der unten angegebenen Verwendungszwecke für die Überweisung, da nur so Ihr Geldeingang zugeordnet werden kann: ';
$_['shopping_type']                                    = 'Einkaufstyp';
$_['shopping_type_desc']                               = 'Einkaufstyp auswählen';
$_['shopping_type_none']                               = 'Keiner';
$_['one_click_shopping']                               = 'Kauf mit einem Klick';
$_['zero_amount_booking']                              = 'Transaktionen mit Betrag 0';
$_['enable_fraud_module']                              = 'Betrugsprüfung aktivieren';
$_['enable_fraud_module_desc']                         = 'Um den Käufer einer Transaktion zu authentifizieren, werden die PIN automatisch generiert und an den Käufer geschickt. Dieser Dienst wird nur für Kunden aus DE, AT und CH angeboten.';
$_['fraud_module_none']                                = 'Keiner';
$_['fraud_module_callback']                            = 'PIN-by-Callback';
$_['fraud_module_sms']                                 = 'PIN-by-SMS';
$_['minimum_val_fraud_module']                         = 'Mindestwarenwert für Betrugsprüfungsmodul (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['minimum_val_fraud_module_desc']                    = 'Geben Sie den Mindestwarenwert ein, von dem ab das Betrugsprüfungsmodul aktiviert sein soll.';
$_['callback_order_status']                            = 'Callback-Bestellstatus';
$_['text_recurring_cancel']                            = 'Recurring order cancelled.';
$_['text_next_charging_date']                          = 'Nächstes Belastungsdatum: ';
$_['button_subscription_cancel']                       = 'Abonnement kündigen';
$_['text_recurring_orders']                            = 'Novalnet-Bestellungen';
$_['text_payment']                                     = 'Zahlarten';
$_['text_extension']                                   = 'Erweiterungen';
$_['text_novalnet_paypal_title']                       = 'PayPal';
$_['guarantee_payment_pending_status']                 = 'Bestellstatus der ausstehenden Zahlung';
