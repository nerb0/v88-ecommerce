<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define("HEADER_DEFAULT", [
	"links" => [],
	"page_title" => "Store"
]);
define("FOOTER_DEFAULT", [
]);

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
}

function render_html($controller, $views, $header_data = HEADER_DEFAULT, $footer_data = FOOTER_DEFAULT) {
	$controller->load->view('__partials/header', $header_data);
	foreach($views as $view => $view_data) {
		$controller->load->view($view, $view_data);
	}
	$controller->load->view('__partials/footer', $footer_data);
}
