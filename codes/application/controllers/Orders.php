<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Order");
	}

	public function show(int $order_id) {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('/login');
		} else if ($user["level"] != 1) {
			redirect('/home');
		}
		$header_data = [
			"include" => [
				"js" => ["admin/order",],
				"css" => [],
			],
			"links" => [
				"Orders" => "/admin/orders",
				"Products" => "/admin/products",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		$view_data = [
			"admin/orders/index" => [
				"order" => $this->Order->get_by_id($order_id),
				"statuses" => $this->Order::STATUS,
			]
		];
		render_admin_html($this, $view_data, $header_data);
	}

	public function list(int $page = 1) {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('/login');
		} else if ($user["level"] != 1) {
			redirect('/home');
		}
		$view_data = [
			"admin/orders/list" => [
				"statuses" => $this->Order::STATUS,
				"total_pages" => $this->Order->get_total_pages(),
			]
		];
		$header_data = [
			"include" => [
				"js" => ["admin/order",],
				"css" => [],
			],
			"links" => [
				"Orders" => "#",
				"Products" => "/admin/products",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		render_admin_html($this, $view_data, $header_data);
	}

	public function list_html(int $page) {
		$filter = $this->input->get(null, true);
		$orders = $this->Order->get($filter);

		$order_list = get_page($orders, $page, $this->Order::ROW_LIMIT);
		$result = $this->load->view("__partials/admin/order/list", [
			"orders" => $order_list,
			"statuses" => $this->Order::STATUS,
		], true);
		$page_btn = $this->load->view("__partials/admin/page_btn",[
			"offset" => 3,
			"field" => "orders",
			"total_pages" => get_total_pages($orders, $this->Order::ROW_LIMIT),
			"current_page" => $page,
		], true);
		if(empty($result)){
			$result = "Page Not Found";
			$pagination = "";
		}
		echo json_encode([
			"data" => [
				"list" => $result,
				"pagination" => $page_btn
			],
		]);
	}

	public function edit(int $order_id) {
		$status = $this->input->post("status", true);
		if (empty($this->Order->get_by_id($order_id))) {
			$http_code = 404;
			$message = "Order cannot be found.";
		} else if (in_array($status, $this->Order::STATUS)){
			$this->Order->update($order_id, $status);
			$http_code = 200;
			$message = "Order#{$order_id} has been updated to {$status}";
		} else {
			$http_code = 500;
			$message = "Invalid Order Status";
		}
		echo json_encode([
			"status" => $http_code,
			"message" => $message
		]);
	}
}

