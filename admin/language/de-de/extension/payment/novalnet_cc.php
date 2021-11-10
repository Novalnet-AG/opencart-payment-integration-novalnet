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

include(DIR_LANGUAGE . 'de-de/extension/payment/novalnet_common.php');
$_['novalnet_heading_title'] = $_['heading_title'] = $_['text_novalnet_cc_title']  = 'Kreditkarte';
$_['entry_enable_3d']                    = '3D-Secure aktivieren';
$_['entry_enable_3d_desc']               = '3D-Secure wird für Kreditkarten aktiviert. Die kartenausgebende Bank fragt vom Käufer ein Passwort ab, welches helfen soll, betrügerische Zahlungen zu verhindern. Dies kann von der kartenausgebenden Bank als Beweis verwendet werden, dass der Käufer tatsächlich der Inhaber der Kreditkarte ist. Damit soll das Risiko von Chargebacks verringert werden.';
$_['entry_display_amex_logo']            = 'AMEX-Logo anzeigen';
$_['entry_display_amex_logo_desc']       = 'AMEX-Logo auf der Checkout-Seite anzeigen';
$_['entry_display_maestro_logo']         = 'Maestro-Logo anzeigen';
$_['entry_display_maestro_logo_desc']    = 'Maestro-Logo auf der Checkout-Seite anzeigen';
$_['onhold_payment_action']    			 = 'Bearbeitungsmaßnahme';
$_['text_novalnet_cc']                   = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_cc']                   = '<img src="../image/payment/novalnet/novalnet_cc.png" border="0" alt="Novalnet Kreditkarte" title="Novalnet Kreditkarte" style="width:17%;"/>&nbsp;<img src="../image/payment/novalnet/novalnet_cc_mastercard.png" border="0" alt="Novalnet Kreditkarte" title="Novalnet Kreditkarte" style="margin-left: -5px !important; margin-top: 0 !important; width:14%;" />';
$_['text_iframe_configuration']          = 'CSS-Einstellungen für den iFrame mit Kreditkartendaten';
$_['text_iframe_form_appearance']        = 'Darstellung des Formulars';
$_['text_iframe_css_text']               = 'Text für das CSS';
$_['text_iframe_input']                  = 'Eingabe';
$_['text_iframe_label']                  = 'Beschriftung';
$_['authorize']    			 			 = 'Zahlung autorisieren';
$_['capture']    						 = 'Zahlung einziehen';
$_['entry_force_enable_3d']              = '3D-Secure-Zahlungen unter vorgegebenen Bedingungen durchführen';
$_['entry_force_enable_3d_desc']         = 'Wenn 3D-Secure in dem darüberliegenden Feld nicht aktiviert ist, sollen 3D-Secure-Zahlungen nach den Einstellungen zum Modul im Novalnet-Admin-Portal unter &quot;3D-Secure-Zahlungen durchführen (gemäß vordefinierten Filtern und Einstellungen)&quot; durchgeführt werden. Wenn die vordefinierten Filter und Einstellungen des Moduls "3D-Secure durchführen" zutreffen, wird die Transaktion als 3D-Secure-Transaktion durchgeführt, ansonsten als Nicht-3D-Secure-Transaktion. Beachten Sie bitte, dass das Modul "3D-Secure-Zahlungen durchführen (gemäß vordefinierten Filtern und Einstellungen)" im Novalnet-Admin-Portal konfiguriert sein muss, bevor es hier aktiviert wird. Für weitere Informationen sehen Sie sich bitte die Beschreibung dieses Betrugsprüfungsmoduls an (unter dem Reiter "Betrugsprüfungsmodule" unterhalb des Menüpunkts "Projekte" für das ausgewähte Projekt im Novalnet-Admin-Portal) oder kontaktieren Sie das Novalnet-Support-Team.';
$_['entry_onhold_limit']                       = 'Limit für onhold-Buchungen setzen (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_onhold_limit_desc']                  = 'Falls der Bestellbetrag das angegebene Limit übersteigt, wird die Transaktion ausgesetzt, bis Sie diese selbst bestätigen.';
