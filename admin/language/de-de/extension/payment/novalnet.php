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
$_['entry_product_activation_key_desc']        = 'Novalnet-Aktivierungsschlüssel für das Produkt eingeben';
$_['error_mandatory_fields']                   = 'Füllen Sie bitte alle Pflichtfelder aus.';
$_['error_email']                              = 'Your E-mail address is invalid';
$_['entry_merchant_id']                        = 'Händler-ID';
$_['entry_authcode']                           = 'Authentifizierungscode';
$_['entry_project_id']                         = 'Projekt-ID';
$_['entry_tariff']                             = 'Tarif-ID';
$_['entry_tariff_desc']                        = 'Novalnet-Tarif-ID auswählen';
$_['entry_payment_access_key']                 = 'Zahlungs-Zugriffsschlüssel';
$_['entry_onhold_limit']                       = 'Limit für onhold-Buchungen setzen (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_onhold_limit_desc']                  = 'Falls der Bestellbetrag das angegebene Limit übersteigt, wird die Transaktion ausgesetzt, bis Sie diese selbst bestätigen.';
$_['entry_payment_logo']                       = 'Logo der Zahlungsart anzeigen';
$_['entry_payment_logo_desc']                  = 'Das Logo der Zahlungsart wird auf der Checkout-Seite angezeigt.';
$_['entry_referrer_id']                        = 'Partner-ID';
$_['entry_referrer_id_desc']                   = 'Geben Sie die Partner-ID der Person / des Unternehmens ein, welche / welches Ihnen Novalnet empfohlen hat.';
$_['entry_proxy_server']                       = 'Proxy-Server';
$_['entry_proxy_server_desc']                  = 'Geben Sie die IP-Adresse Ihres Proxyservers zusammen mit der Nummer des Ports ein und zwar in folgendem Format: IP-Adresse : Nummer des Ports (falls notwendig)';
$_['entry_gateway_timeout']                    = 'Zeitlimit der Schnittstelle (in Sekunden)';
$_['entry_gateway_timeout_desc']               = 'Falls die Verarbeitungszeit der Bestellung das Zeitlimit der Schnittstelle überschreitet, wird die Bestellung nicht ausgeführt.';
$_['entry_onhold_management']                  = 'Verwaltung des Bestellstatus für ausgesetzte Zahlungen';
$_['entry_onhold_confirm_status']              = 'On-hold-Bestellstatus';
$_['entry_onhold_cancel_status']               = 'Bestellstatus für Stornierung';
$_['entry_merchant_script_management']         = 'Verwaltung des Händlerskripts';
$_['entry_merchant_script_test_mode']          = 'Deaktivieren Sie die IP-Adresskontrolle (nur zu Testzwecken)';
$_['entry_merchant_script_test_mode_desc']     = 'Diese Option ermöglicht eine manuelle Ausführung. Bitte deaktivieren Sie diese Option, bevor Sie Ihren Shop in den LIVE-Modus schalten, um nicht autorisierte Zugriffe von externen Parteien (außer von Novalnet) zu vermeiden.';
$_['entry_merchant_script_mail_notification']  = 'Email-Benachrichtigung für Callback aktivieren';
$_['entry_notification_url']                   = 'URL für Benachrichtigungen';
$_['entry_notification_url_desc']              = 'Der URL für Benachrichtigungen dient dazu, Ihre Datenbank / Ihr System auf einem aktuellen Stand zu halten und den Novalnet-Transaktionsstatus abzugleichen.';
$_['entry_email_to_addr']                      = 'Emailadresse (An)';
$_['entry_email_to_addr_desc']                 = 'Emailadresse des Empfängers';
$_['entry_email_bcc_addr']                     = 'Emailadresse (Bcc)';
$_['entry_email_bcc_addr_desc']                = 'Emailadresse des Empfängers für Bcc';
$_['text_novalnet']                            = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['entry_admin_portal_src']                   = 'Um zusätzliche Einstellungen vorzunehmen, loggen Sie sich in das <a href="https://admin.novalnet.de" target="_blank" style="text-decoration: underline;">Novalnet-Händleradministrationsportal</a>. Um sich in das Portal einzuloggen, benötigen Sie einen Account bei Novalnet. Falls Sie diesen noch nicht haben, kontaktieren Sie bitte <a href="mailto:sales@novalnet.de">sales@novalnet.de</a> (Tel: +49 (089) 923068320).';
$_['entry_paypal_admin_portal_src']            = 'Um die Zahlungsart PayPal zu verwenden, geben Sie bitte Ihre PayPal-API-Daten in das <a href="https://admin.novalnet.de/" target="_blank" style="text-decoration: underline;">Novalnet-Händleradministrationsportal</a> ein';
$_['package_error']                            = 'Erwähnt PHP-Paket (e) in diesem Server nicht verfügbar ist. Bitte aktivieren Sie sie.';
