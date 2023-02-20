<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_Items extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
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
}
