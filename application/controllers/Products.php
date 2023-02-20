<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Product");
		$this->load->model("Category");
	}

	public function index() {
		// $user_id = $this->session->userdata("user_id");
		// redirect($user_id ? "/dashboard" : "login");
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

	public function list() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_admin_html($this, [
			"admin/products/list" => [
				"products" => $this->Product->get_all(),
			]
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

	public function edit() {
		var_dump($this->input->post(null, true));
		var_dump($_FILES);
	}
	public function add() {
		$result = $this->Product->validate();

		if ($result == 'valid') {
			$post = $this->input->post(null, true);
			var_dump($post);
			$post["category_id"] = $post["category"];
			if (!empty($post["new_category"])) {
				$post["category_id"] = $this->Category->create($post["new_category"]);
			}
			$product_id = $this->Product->create($post);
			$this->Product->upload_images($product_id, $post["main_image"]);
			$message = "success";
		} else {
			$message = $result;
			$this->session->set_flashdata("message_type", "error");
		}
		$this->session->set_flashdata("message", $message);
		redirect("/admin/products");
	}

	public function edit_html($product_id) {
		echo json_encode([
			"response" => $this->load->view("__partials/edit_product", ["id" => $product_id], true),
		]);
	}
	public function add_html() {
		echo json_encode([
			"response" => $this->load->view("__partials/add_product", [
				"categories" => $this->Category->get_all(),
			] , true),
		]);
	}

	// NOTE: FORM VALIDATION's CUSTOM CALLBACK FUNCTIONS
	// The functions below are for form_validation
	// Additionally, all of the functions below are removed from the route
	public function valid_category($category_id) {
		if (strlen($category_id) == 0) return true;
		// Check if the selected category id exists in the database
		return !empty($this->Category->get_by_id($category_id));
	}
	public function is_category_needed($category_id) {
		// NOTE: Invalidate if the user decides to remove both the values
		// of category and new category. At least one of the two must be sent
		// to POST to be validated
		if (
			strlen($this->input->post("new_category", true)) == 0 &&
			strlen($category_id) == 0
		) return false; 
		return true;
	}
	public function valid_new_category($category_name) {
		if (strlen($category_name) == 0) return true;
		// Check if the new category name does not exists in the database
		return empty($this->Category->get_by_name($category_name));
	}
	public function valid_new_images() {
		if (empty($_FILES["new_images"])) return true;

		for($i = 0; $i < count($_FILES["new_images"]["name"]); $i++ ){
			if ($_FILES["new_images"]["error"][$i] != 0) return false;
			if (!in_array(get_extension($_FILES["new_images"]["name"][$i]), ["jpg", "png", "jpeg", "gif"])) return false;
		}
		return true;
	}
}
