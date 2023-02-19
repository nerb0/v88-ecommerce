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
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_html($this, [
			"products/home" => [
				"user" => $user
			]
		], [
			"links" => [
				"Home" => "#",
				"Catalog" => "/products/catalog",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		]);
	}

	public function catalog() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_html($this, [
			"products/catalog" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "#",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		]);
	}

	public function show(int $product_id) {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_html($this, [
			"products/index" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		]);
	}

	public function cart() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_html($this, [
			"products/cart" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		]);
	}

	public function checkout() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_html($this, [
			"products/checkout" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		]);
	}

	public function list() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_admin_html($this, [
			"admin/products/list" => []
		], [
			"links" => [
				"Orders" => "/admin/orders",
				"Products" => "#",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		]);
	}
}
