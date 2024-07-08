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
 * Script : novalnet.php
 */

include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title']                       = 'Novalnet Haupteinstellungen';
$_['entry_cron_job_url']                       = 'URL des Cron-Jobs';
$_['entry_cron_job_url_desc']                  = 'Cron-Job einstellen, um diese URL aufzurufen';
$_['entry_enable_payment']                     = 'Zahlungsart aktivieren';
$_['entry_product_activation_key']             = 'Aktivierungsschlüssel des Produkts';
$_['entry_product_activation_key_desc']        = 'Ihren Produktaktivierungsschlüssel finden Sie im Novalnet-Händleradminportal: Projekte > Wählen Sie Ihr Projekt > API-Anmeldeinformationen > API-Signatur (Produktaktivierungsschlüssel).';
$_['entry_client_key']            			   = 'Schlüsselkunde';
$_['error_mandatory_fields']                   = 'Bitte füllen Sie die erforderlichen Felder aus';
$_['error_email']                              = 'Your E-mail address is invalid';
$_['entry_merchant_id']                        = 'Händler-ID';
$_['entry_authcode']                           = 'Authentifizierungscode';
$_['entry_project_id']                         = 'Projekt-ID';
$_['entry_tariff']                             = 'Auswahl der Tarif-ID';
$_['entry_tariff_desc']                        = 'Wählen Sie eine Tarif-ID, die dem bevorzugten Tarifplan entspricht, den Sie im Novalnet-Händleradminportal 
für dieses Projekt erstellt haben';
$_['entry_payment_access_key']                 = 'Zahlungs-Zugriffsschlüssel';
$_['entry_onhold_limit']                       = 'Limit für onhold-Buchungen setzen (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_onhold_limit_desc']                  = 'Falls der Bestellbetrag das angegebene Limit übersteigt, wird die Transaktion ausgesetzt, bis Sie diese selbst bestätigen.';
$_['entry_payment_logo']                       = 'Zahlungslogo anzeigen';
$_['entry_payment_logo_desc']                  = 'Das Logo der Zahlungsart wird auf der Checkout-Seite angezeigt.';
$_['entry_onhold_management']                  = 'Verwaltung des Bestellstatus für ausgesetzte Zahlungen';
$_['entry_onhold_confirm_status']              = 'On-hold-Bestellstatus';
$_['entry_onhold_cancel_status']               = 'Bestellstatus für Stornierung';
$_['entry_merchant_script_management']         = 'Verwaltung des Händlerskripts';
$_['entry_merchant_script_test_mode']          = 'Manuelles Testen der Benachrichtigungs- / Webhook-URL erlauben';
$_['entry_merchant_script_test_mode_desc']     = 'Aktivieren Sie diese Option, um die Novalnet-Benachrichtigungs-/Webhook-URL manuell zu testen. Deaktivieren Sie die Option, bevor Sie Ihren Shop liveschalten, um unautorisierte Zugriffe von Dritten zu blockieren';
$_['entry_merchant_script_mail_notification']  = 'E-Mail-Benachrichtigungen einschalten';
$_['entry_merchant_script_mail_notification_desc'] = 'Aktivieren Sie diese Option, um die angegebene E-Mail-Adresse zu benachrichtigen, wenn die Benachrichtigungs- / Webhook-URL erfolgreich ausgeführt wurde ';
$_['entry_notification_url']                   = 'Benachrichtigungs- / Webhook-URL';
$_['entry_notification_url_desc']              = 'Eine Benachrichtigungs- / Webhook-URL ist erforderlich, um die Datenbank / das System des Händlers mit dem Novalnet-Account synchronisiert zu halten (z.B. Lieferstatus). Weitere Informationen finden Sie in der Installationsanleitung';
$_['entry_email_to_addr']                      = 'E-Mails senden an';
$_['entry_email_to_addr_desc']                 = 'E-Mail-Benachrichtigungen werden an diese E-Mail-Adresse gesendet';
$_['text_novalnet']                            = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['entry_admin_portal_src']                   = 'Bevor Sie beginnen, lesen Sie bitte die Installationsanleitung und melden Sie sich mit Ihrem Händlerkonto im <a href="https://admin.novalnet.de" target="_blank" style="text-decoration: underline;">Novalnet Admin-Portal</a> an. Um ein Händlerkonto zu erhalten, senden Sie bitte eine E-Mail an <a  href="mailto:sales@novalnet.de">sales@novalnet.de</a> oder rufen Sie uns unter +49 89 923068320 an';
$_['entry_paypal_admin_portal_src']            = 'Um PayPal-Transaktionen zu akzeptieren, konfigurieren Sie Ihre PayPal-API-Informationen im <a href="https://admin.novalnet.de" target="_blank" style="text-decoration: underline;"> Novalnet Admin-Portal</a> > PROJEKT > Wählen Sie Ihr Projekt > Zahlungsmethoden > Paypal > Konfigurieren';
$_['package_error']                            = 'Erwähnt PHP-Paket (e) in diesem Server nicht verfügbar ist. Bitte aktivieren Sie sie.';
