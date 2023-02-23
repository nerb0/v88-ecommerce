<?php defined('BASEPATH') OR exit('No direct script access allowed');

function render_html($controller, $views, $header_data = [], $footer_data = []) {
	$controller->load->view('__partials/header', $header_data);
	foreach($views as $view => $view_data) {
		$controller->load->view($view, $view_data);
	}
	$controller->load->view('__partials/footer', $footer_data);
}

function render_admin_html($controller, $views, $header_data = [], $footer_data = []) {
	$controller->load->view('__partials/admin/header', $header_data);
	foreach($views as $view => $view_data) {
		$controller->load->view($view, $view_data);
	}
	$controller->load->view('__partials/admin/footer', $footer_data);
}

function get_extension($filename) {
	return pathinfo($filename, PATHINFO_EXTENSION);
}
function get_filename($path) {
	return pathinfo($path, PATHINFO_FILENAME);
}
function get_basename($path) {
	return pathinfo($path, PATHINFO_BASENAME);
}
function get_page($array, $page, $row_limit) {
	$start = ($page - 1) * $row_limit;
	if ($start > count($array)) return false;
	return array_slice($array, $start, $row_limit);
}
function get_total_pages($array, $row_limit) {
	return ceil(count($array) / $row_limit);
}
