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
			"products/catalog" => [
				"products" => $this->Product->get_all(),
			]
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

	public function show($product_id) {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}

		$products = $this->Product->get_by_id($product_id);
		$products["images"] = json_decode($products["images"], true);
		render_html($this, [
			"products/index" => [
				"product" => $products
			]
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

		$products = $this->Product->get_all();
		render_admin_html($this, [
			"admin/products/list" => [
				"products" => $products
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
	public function edit($product_id) {
		$result = $this->Product->validate();
		$post = $this->input->post(null, true);

		if ($result == 'valid') {
			$post["category_id"] = $post["category"];
			if (!empty($post["new_category"])) {
				$post["category_id"] = $this->Category->create($post["new_category"]);
			}
			$this->Product->update($product_id, $post);
			$this->Product->upload_images(
				$product_id,
				$post["main_image"],
				$post["images"],
				// NOTE: Since the new image and old image cannot be sent on the same POST variable
				// I put the indexes on a new variable `image_sort` based on their position
				// The value is on a stringified JSON
				json_decode($post["image_sort"], true)
			);
			$message = "Successfully edited Product #{$product_id}";
		} else {
			$message = $result;
			$this->session->set_flashdata("message_type", "error");
		}
		$this->session->set_flashdata("message", $message);
		redirect("/admin/products");
	}
	public function remove($product_id) {
		$result = $this->Product->delete($product_id);
		if ($result) {
			$status = 200;
			$message = "Successfully deleted Product #{$product_id}";
		} else {
			$status = 500;
			$message = "Something went wrong. Please try again later";
		}
		echo json_encode([
			"status" => $status,
			"message" => $message,
		]);
	}
	public function add() {
		$result = $this->Product->validate();
		$post = $this->input->post(null, true);

		if ($result == 'valid') {
			$post["category_id"] = $post["category"];
			if (!empty($post["new_category"])) {
				$post["category_id"] = $this->Category->create($post["new_category"]);
			}
			$product_id = $this->Product->create($post);
			$this->Product->upload_images($product_id, $post["main_image"]);
			$message = "Successfully added new Product.";
		} else {
			$message = $result;
			$this->session->set_flashdata("message_type", "error");
		}
		$this->session->set_flashdata("message", $message);
		redirect("/admin/products");
	}

	public function edit_html($product_id) {
		$product = $this->Product->get_by_id($product_id);
		$product["images"] = json_decode($product["images"], true);
		echo json_encode([
			"response" => $this->load->view("__partials/edit_product", [
				"product" => $product,
				"categories" => $this->Category->get_all(),
			], true),
		]);
	}
	public function add_html() {
		echo json_encode([
			"response" => $this->load->view("__partials/add_product", [
				"categories" => $this->Category->get_all(),
			] , true),
		]);
	}
	public function remove_html($product_id) {
		$product = $this->Product->get_by_id($product_id);
		echo json_encode([
			"response" => $this->load->view("__partials/remove_product",
				$product
			, true),
		]);
	}

	// FORM VALIDATION's CUSTOM CALLBACK FUNCTIONS
	// The functions below are for form_validation
	// Additionally, all of the functions below are removed from the route
	public function valid_category($category_id) {
		// NOTE: This line is necessary for not overriding the require callback from CodeIgniter
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
	public function valid_main_image($main_image) {
		if (strlen($main_image) == 0) return true;

		if (ctype_digit(strval($main_image))) {
			return $main_image < count($_FILES["new_images"]["name"]);
		} else {
			return in_array($main_image, $this->input->post("images", true));
		}
	}
	public function valid_new_images() {
		if (empty($_FILES["new_images"])) return true;

		for($i = 0; $i < count($_FILES["new_images"]["name"]); $i++ ){
			if ($_FILES["new_images"]["error"][$i] != 0) return false;
			// NOTE: Only this 4 file types will be allowed
			if (!in_array(get_extension($_FILES["new_images"]["name"][$i]), ["jpg", "png", "jpeg", "gif"])) return false;
		}
		return true;
	}
}
