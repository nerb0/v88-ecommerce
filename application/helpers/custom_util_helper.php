<?php defined('BASEPATH') OR exit('No direct script access allowed');

function render_html($controller, $views, $header_data = [], $footer_data = []) {
	$controller->load->view('__partials/header', $header_data);
	foreach($views as $view => $view_data) {
		$controller->load->view($view, $view_data);
	}
	$controller->load->view('__partials/footer', $footer_data);
}

function render_admin_html($controller, $views, $header_data = [], $footer_data = []) {
	$controller->load->view('__partials/admin_header', $header_data);
	foreach($views as $view => $view_data) {
		$controller->load->view($view, $view_data);
	}
	$controller->load->view('__partials/admin_footer', $footer_data);
}
