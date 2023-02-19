<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$user_id = $this->session->userdata("user_id");
		redirect($user_id ? "/dashboard" : "login");
	}

	public function login() {
		render_html($this, [
			"users/login" => []
		]);
	}

	public function register() {
		render_html($this, [
			"users/register" => []
		]);
	}

	public function profile() {
		render_html($this, [
			"users/profile" => []
		], [
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			]
		]);
	}
}

