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
$_['novalnet_heading_title'] = $_['heading_title'] = $_['text_novalnet_cc_title']  = 'Kredit- / Debitkarte';
$_['entry_enable_3d']                    = '3D-Secure-Zahlungen außerhalb der EU erzwingen';
$_['entry_enable_3d_desc']               = 'Wenn Sie diese Option aktivieren, werden alle Zahlungen mit Karten, die außerhalb der EU ausgegeben wurden, mit der starken Kundenauthentifizierung (Strong Customer Authentication, SCA) von 3D-Secure 2.0 authentifiziert.';
$_['entry_display_amex_logo']            = 'AMEX-Logo anzeigen';
$_['entry_display_amex_logo_desc']       = 'AMEX-Logo auf der Checkout-Seite anzeigen';
$_['entry_display_maestro_logo']         = 'Maestro-Logo anzeigen';
$_['entry_display_maestro_logo_desc']    = 'Maestro-Logo auf der Checkout-Seite anzeigen';
$_['onhold_payment_action']    			 = 'Bearbeitungsmaßnahme';
$_['onhold_payment_action_desc']  = ' Wählen Sie, ob die Zahlung sofort belastet werden soll oder nicht. Zahlung einziehen: Betrag sofort belasten. Zahlung autorisieren: Die Zahlung wird überprüft und autorisiert, aber erst zu einem späteren Zeitpunkt belastet. So haben Sie Zeit, über die Bestellung zu entscheiden';
$_['text_novalnet_cc']                   = '<a href="https://www.novalnet.de" target="_blank"><img src="../image/payment/novalnet/novalnet.png" border="0" alt="Novalnet AG" title="Novalnet AG" height="23" /></a>';
$_['logo_novalnet_cc']                   = '<img src="../image/payment/novalnet/novalnet_cc.png" border="0" alt="Novalnet Kreditkarte" title="Novalnet Kreditkarte" style="width:17%;"/>&nbsp;<img src="../image/payment/novalnet/novalnet_cc_mastercard.png" border="0" alt="Novalnet Kreditkarte" title="Novalnet Kreditkarte" style="margin-left: -5px !important; margin-top: 0 !important; width:14%;" />';
$_['text_iframe_configuration']          = 'CSS-Einstellungen für den iFrameformular';
$_['text_iframe_form_appearance']        = 'Darstellung des Formulars';
$_['text_iframe_css_text']               = 'Text für das CSS';
$_['text_iframe_input']                  = 'Eingabe';
$_['text_iframe_label']                  = 'Beschriftung';
$_['authorize']    			 			 = 'Zahlung autorisieren';
$_['capture']   						 = 'Zahlung einziehen';
$_['entry_onhold_limit']                       = 'Limit für onhold-Buchungen setzen (in der kleinsten Währungseinheit, z.B. 100 Cent = entsprechen 1.00 EUR)';
$_['entry_onhold_limit_desc']                  = 'Falls der Bestellbetrag das angegebene Limit übersteigt, wird die Transaktion ausgesetzt, bis Sie diese selbst bestätigen.';
