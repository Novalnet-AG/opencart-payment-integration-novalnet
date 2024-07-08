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
 
include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['novalnet_heading_title']  = $_['heading_title']            = $_['text_novalnet_sepa_title'] = 'Lastschrift SEPA';
$_['text_sepa_due_date']       = 'Abstand (in Tagen) bis zum SEPA-Einzugsdatum';
$_['text_sepa_due_date_desc']  = 'Geben Sie die Anzahl der Tage ein, nach denen die Zahlung verarbeitet werden soll (muss zwischen 2 und 14 Tagen liegen)';
$_['error_duration_date']      = 'SEPA Fälligkeitsdatum Ungültiger';
$_['text_novalnet_sepa']       = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_sepa']       = '<img src="../image/payment/novalnet/novalnet_sepa.png" border="0" alt="Novalnet Lastschrift SEPA" title="Novalnet Lastschrift SEPA" />';
$_['onhold_payment_action']    = 'Bearbeitungsmaßnahme';
$_['onhold_payment_action_desc']  = ' Wählen Sie, ob die Zahlung sofort belastet werden soll oder nicht. Zahlung einziehen: Betrag sofort belasten. Zahlung autorisieren: Die Zahlung wird überprüft und autorisiert, aber erst zu einem späteren Zeitpunkt belastet. So haben Sie Zeit, über die Bestellung zu entscheiden';
$_['authorize']    			 			 = 'Zahlung autorisieren';
$_['capture']    						 = 'Zahlung einziehen';
$_['entry_onhold_limit']                       = 'Limit für onhold-Buchungen setzen (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_onhold_limit_desc']                  = 'Falls der Bestellbetrag das angegebene Limit übersteigt, wird die Transaktion ausgesetzt, bis Sie diese selbst bestätigen.';
