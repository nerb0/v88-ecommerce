<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		// $user_id = $this->session->userdata("user_id");
		// redirect($user_id ? "/dashboard" : "login");
	}

	public function home() {
		render_html($this, [
			"products/home" => []
		], [
			"links" => [
				"Home" => "#",
				"Catalog" => "/products/catalog",
			]
		]);
	}

	public function catalog() {
		render_html($this, [
			"products/catalog" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "#",
			]
		]);
	}

	public function show(int $product_id) {
		render_html($this, [
			"products/index" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			]
		]);
	}
	public function cart() {
		render_html($this, [
			"products/cart" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			]
		]);
	}
}

