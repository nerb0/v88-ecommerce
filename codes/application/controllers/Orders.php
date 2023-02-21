<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function show(int $order_id) {
		render_admin_html($this, [
			"admin/orders/index" => []
		], [
			"links" => [
				"Orders" => "/admin/orders",
				"Products" => "/admin/products",
			]
		]);
	}

	public function list() {
		render_admin_html($this, [
			"admin/orders/list" => []
		], [
			"links" => [
				"Orders" => "#",
				"Products" => "/admin/products",
			]
		]);
	}
}

