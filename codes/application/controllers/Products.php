<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Cart");
		$this->load->model("Product");
		$this->load->model("Category");
	}

	public function catalog() {
		$user = $this->User->get_by_session();
		$filter = $this->input->get(null, true);
		$view_data = [
			"products/catalog" => [
				"total_pages" => $this->Product->get_total_pages(),
				"categories" => $this->Category->get_all(),
				"selected_category" => $filter["category"] ?? "",
				"search" => $filter["search"] ?? "",
			]
		];
		$header_data = [
			"include" => [
				"js" => ["product"],
				"css" => [],
			],
			"links" => [
				"Home" => "/home",
				"Catalog" => "#",
			],
			"cart_count" => count($this->Cart->get_user_items($user["id"] ?? -1)) ?? 0,
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		render_html($this, $view_data, $header_data);
	}

	public function show($product_id) {
		$this->load->model("Review");
		$this->load->model("Reply");
		$user = $this->User->get_by_session();
		$product = $this->Product->get_by_id($product_id);
		if (empty($product)) {
			redirect("/home");
		}

		$similar_products = $this->Product->get_similar($product["category_id"], $product_id);
		$product["images"] = json_decode($product["images"], true);
		$view_data = [
			"products/index" => [
				"similar_products" => $similar_products,
				"product" => $product,
				"reviews" => $this->Review->get_by_product_id($product_id),
				"replies" => $this->Reply->get_grouped_by_product_id($product_id),
			]
		];
		$header_data = [
			"include" => [
				"js" => ["product"],
				"css" => [],
			],
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			],
			"cart_count" => count($this->Cart->get_user_items($user["id"] ?? 0)),
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		render_html($this, $view_data, $header_data );
	}
	public function preview() {
		$user = $this->User->get_by_session();
		if(empty($user)) {
			redirect('login');
		}
		if ($user["id"] != 1) {
			redirect('/home');
		}
		$post = $this->input->post(null, true);
		if (!empty($_FILES["new_images"]["tmp_name"])) {
			foreach($_FILES["new_images"]["tmp_name"] as $index => $tmp_name) {
				$content = file_get_contents($tmp_name);
				$post["images"][] = "data:image/jpeg;base64," . base64_encode($content);
			}
		}
		$this->load->view("products/preview", $post);
	}

	public function list() {
		$user = $this->User->get_by_session();
		if(empty($user)) {
			redirect('login');
		}
		if ($user["id"] != 1) {
			redirect('/home');
		}

		$view_data = [
			"admin/products/list" => [
				"total_pages" => $this->Product->get_total_pages()
			]
		];
		$header_data = [
			"include" => [
				"js" => ["admin/product",],
				"css" => [],
			],
			"links" => [
				"Orders" => "/admin/orders",
				"Products" => "#",
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		render_admin_html($this, $view_data, $header_data );
	}
	public function edit($product_id) {
		$result = $this->Product->validate();
		$post = $this->input->post(null, true);

		if ($result == 'valid') {
			$post["category_id"] = $post["category"];
			if (!empty($post["new_category"])) {
				$post["category_id"] = $this->Category->create($post["new_category"]);
			}
			if (!empty($post["updated_category_list"])) {
				$updated_categories = json_decode($post["updated_category_list"], true);
				foreach ($updated_categories as $id => $new_name) {
					$this->Category->update($id, $new_name);
				}
				$this->Category->delete_not_in_list(array_keys($updated_categories));
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
			echo json_encode([
				"status" => 200,
				"message" => "Successfully edited Product #{$product_id}",
				"data" => [
					"last_page" => $this->Product->get_total_pages()
				]
			]);
		} else {
			echo json_encode([
				"status" => 500,
				"message" => $result,
			]);
		}
	}
	public function delete($product_id) {
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
			$status = 200;
		} else {
			$message = $result;
			$status = 500;
		}
		echo json_encode([
			"status" => $status,
			"message" => $message,
		]);
	}


	// NOTE: API Endpoints for AJAX calls
	public function edit_html($product_id) {
		$product = $this->Product->get_by_id($product_id);
		$product["images"] = json_decode($product["images"], true);
		echo json_encode([
			"data" => $this->load->view("__partials/admin/product/edit", [
				"product" => $product,
				"categories" => $this->Category->get_all(),
			], true),
		]);
	}
	public function add_html() {
		echo json_encode([
			"data" => $this->load->view("__partials/admin/product/add", [
				"categories" => $this->Category->get_all(),
			] , true),
		]);
	}
	public function remove_html($product_id) {
		$product = $this->Product->get_by_id($product_id);
		echo json_encode([
			"data" => $this->load->view("__partials/admin/product/remove", 
				$product
			, true),
		]);
	}
	public function list_html($page) {
		$filter = $this->input->get(null, true);
		$products = $this->Product->get($filter);
		$product_list = get_page($products, $page, $this->Product::ADMIN_ROW_LIMIT);
		$result = $this->load->view("__partials/admin/product/list",[
			"products" => $product_list
		], true);
		$page_btn = $this->load->view("__partials/admin/page_btn",[
			"offset" => 3,
			"field" => "products",
			"total_pages" => get_total_pages($products, $this->Product::ADMIN_ROW_LIMIT),
			"current_page" => $page,
		], true);
		if(empty($result)){
			$result = "Page Not Found";
			$pagination = "";
		}
		echo json_encode([
			"data" => [
				"list" => $result,
				"pagination" => $page_btn,
			],
		]);
	}
	public function catalog_html($page) {
		$filter = $this->input->get(null, true);
		$products = $this->Product->get($filter);
		$product_list = get_page($products, $page, $this->Product::ROW_LIMIT);
		$result = $this->load->view("__partials/catalog",[
			"products" => $product_list
		], true);
		$pages = $this->load->view("__partials/catalog_page_btn", [
				"total_pages" => get_total_pages($products, $this->Product::ROW_LIMIT),
				"current_page" => $page,
		], true);
		if(empty($product_list)){
			$result = "No Products Found";
			$pages = "";
		} 
		echo json_encode([
			"pages" => $pages,
			"data" => $result,
		]);
	}

	// NOTE: FORM VALIDATION's CUSTOM CALLBACK FUNCTIONS
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
