<?php
/**
 *
 * Novalnet admin portal
 * This module is used for real time processing of
 * Novalnet transaction of customers.
 *
 * Copyright (c) Novalnet
 *
 * Released under the GNU General Public License
 * This free contribution made by request.
 * If you have found this script useful a small
 * recommendation as well as a comment on merchant form
 * would be greatly appreciated.
 *
 * Script : admin_portal.php
 *
 * @author    Novalnet AG
 * @copyright Copyright by Novalnet
 * @license   https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 *
 */

class ControllerNovalnetAdminPortal extends Controller {

	/**
	 * To display the novalnet admin portal
	 *
	 * @param       void
	 * @return      void
	 */
	public function index() {
		$this->load->language('extension/payment/novalnet_common');
		$data['login_msg'] = $this->language->get('login_msg');
		$data['header']         = $this->load->controller('common/header');
		$data['column_left']    = $this->load->controller('common/column_left');
		$data['footer']         = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('novalnet/admin_portal', $data));
	}
}
