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
$_['text_title']                         = $_['text_novalnet_sepa_title']           = 'Lastschrift SEPA';
$_['text_payment_description']           = 'Ihr Konto wird nach Abschicken der Bestellung belastet.';
$_['text_sepa_account_holder']           = 'Kontoinhaber';
$_['text_sepa_account_no']               = 'IBAN oder Kontonummer';
$_['text_sepa_mandate_confirmation']     = 'Ich erteile hiermit das SEPA-Lastschriftmandat (elektronische Übermittlung) und bestätige, dass die Bankverbindung korrekt ist.';
$_['text_sepa_mandate_confirmation_desc']     = 'Ich ermächtige den Zahlungsempfänger, Zahlungen von meinem Konto mittels Lastschrift einzuziehen. Zugleich weise ich mein Kreditinstitut an, die von dem Zahlungsempfänger auf mein Konto gezogenen Lastschriften einzulösen.
          <br>
          <br>
          <strong>Gläubiger-Identifikationsnummer: DE53ZZZ00000004253</strong>
          <br>
          <br>
          <strong>Hinweis:</strong> Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des belasteten Betrages verlangen. Es gelten dabei die mit meinem Kreditinstitut vereinbarten Bedingungen.
        </div>';
$_['novalnet_sepa_payment_details_error']              = 'Ihre Kontodaten sind ungültig.';
$_['error_sepa_mandate']                 = 'Akzeptieren Sie bitte das SEPA-Lastschriftmandat';
$_['error_sepa_due_date']                = 'SEPA Fälligkeitsdatum Ungültiger';
$_['novalnet_sepa_new_account_details']     = 'Neue Kontodaten eingeben';
$_['novalnet_sepa_given_account_details']   = 'Eingegebene Kontodaten';
$_['payment_logo']                       = '<img id="novalnet_sepa_logo" src="image/payment/novalnet/novalnet_sepa.png" alt="Lastschrift SEPA" title="Lastschrift SEPA" style="width:46px; height:14px;"/>';
$_['save_card_details']               = 'Meine Kontodaten für zukünftige Bestellungen speichern';
