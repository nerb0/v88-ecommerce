<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Order");
	}

	public function show(int $order_id) {
		$header_data = [
			"links" => [
				"Orders" => "/admin/orders",
				"Products" => "/admin/products",
			]
		];
		$view_data = [
			"order" => $this->Order->get_by_id($order_id),
		];
		render_admin_html($this, [
			"admin/orders/index" => $view_data
		], $header_data);
	}

	public function list(int $page = 1) {
		$view_data = [
			"admin/orders/list" => [
				"statuses" => $this->Order::STATUS,
				"total_pages" => $this->Order->get_total_pages(),
			]
		];
		$header_data = [
			"links" => [
				"Orders" => "#",
				"Products" => "/admin/products",
			]
		];

		render_admin_html($this, $view_data, $header_data);
	}

	public function list_html(int $page) {
		$result = $this->Order->get($page);
		if(empty($result)) $result = "Page Not Found";
		echo json_encode([
			"response" => $this->load->view("__partials/order_list", [
				"orders" => $result,
				"statuses" => $this->Order::STATUS,
			], true),
		]);
	}
}

