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
 *
 */
class ControllerExtensionModuleNovalnet extends Controller {
    public function logout() {
        if(isset($this->session->data['novalnet_sepa_max_time'])){
            unset($this->session->data['novalnet_sepa_max_time']);
        }
        if(isset($this->session->data['novalnet_invoice_max_time'])){
            unset($this->session->data['novalnet_invoice_max_time']);
        }
        if(isset($this->session->data['novalnet_invoice'])){
            unset($this->session->data['novalnet_invoice']);
        }
        if(isset($this->session->data['novalnet_sepa'])){
            unset($this->session->data['novalnet_sepa']);
        }
    }
}
