<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_Items extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Cart");
		$this->load->model("Product");
	}

	public function index() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		$view_data = [
			"products/cart" => [
				"items" => $this->Cart->get_user_items($user["id"]),
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
			"cart_count" => count($this->Cart->get_user_items($user["id"])),
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		render_html($this, $view_data, $header_data);
	}

	public function checkout() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		$items = $this->input->get("cart_items", true);
		if(empty($items)) {
			redirect("/cart");
		}
		$selected_items = $this->Cart->get_selected_items($items);
		if(empty($selected_items)) {
			redirect("/cart");
		}
		$subtotal = $this->Cart->calculate_total_price($items);
		$shipping_fee = count($selected_items) * 24;
		$view_data = [
			"products/checkout" => [
				"default_address" => $this->User->get_default_address(),
				"selected_items" => $selected_items,
				"subtotal" => number_format($subtotal, 2),
				"shipping_fee" => number_format($shipping_fee, 2),
				"order_total" => number_format($shipping_fee + $subtotal, 2),
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
			"cart_count" => count($this->Cart->get_user_items($user["id"])),
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		render_html($this, $view_data, $header_data);
	}
	public function process_checkout() {
		$user = $this->User->get_by_session();
		if (empty($user)) {
			redirect("/login");
		}

		$post = $this->input->post(null, true);
		$result = $this->Cart->validate();
		$url_param = implode("&", array_map(function($item){
			return "checkout_items[]={$item}";
		}, $post["checkout_items"]));
		if ($result == "valid") {
			$this->load->model("Order");
			$stripe = new \Stripe\StripeClient($_SERVER["HTTP_STRIPE_KEY"]);
			$expiry = DateTime::createFromFormat("m/Y", $post["card_expiry"]);
			$sub_total = $this->Cart->calculate_total_price($post["checkout_items"]);
			$shipping_fee = count($post["checkout_items"]) * $this->Order::SHIPPING_FEE;
			try {
				// NOTE: This is to create a token card to verify if the card is valid
				$token = $stripe->tokens->create([
					'card' => [
						'number' => $post["card_number"],
						'exp_month' => $expiry->format("n"),
						'exp_year' => $expiry->format("Y"),
						'cvc' => $post["card_cvc"],
						'name' => "{$post["billing_first_name"]} {$post["billing_last_name"]}",
						'address_line1' => $post["billing_address"],
						'address_line2' => $post["billing_address_two"],
						'address_city' => $post["billing_city"],
						'address_state' => $post["billing_state"],
						'address_zip' => $post["billing_zipcode"],
					],
				]);
				$charge = $stripe->charges->create([
					"source" => $token->id,
					"currency" => "usd",
					// NOTE: Stripe does not accept floating point values and only allows the smallest value for the currency 
					// In this instance, since I'm using USD, the smallest value is 1 cent which 100 cents is equal to 1 usd
					"amount" => ($sub_total + $shipping_fee) * 100,
					"shipping" => [
						"name" => "{$post["shipping_first_name"]} {$post["shipping_last_name"]}",
						"address" => [
							"city" => $post["shipping_city"],
							"state" => $post["shipping_state"],
							"postal_code" => $post["shipping_zipcode"],
							"line1" => $post["shipping_address"],
							"line2" => $post["shipping_address_two"] ?? "",
						],
					],
					"receipt_email" => $post["billing_email"],
				]);
				$order_items = json_encode(array_reduce($post["checkout_items"], function($res, $cart_id){
					$cart_item = $this->Cart->get_by_id($cart_id);
					$product = $this->Product->get_by_id($cart_item["product_id"]);
					$res[$cart_item["product_id"]] = [
						"name" => $product["name"],
						"price" => $product["price"],
						"quantity" => $cart_item["quantity"],
					];
					$this->Cart->delete($cart_id);
					return $res;
				}, []));
				$addresses = json_encode([
					"shipping" => [
						"first_name" => $post["shipping_first_name"],
						"last_name" => $post["shipping_last_name"],
						"email" => $post["shipping_email"],
						"address" => $post["shipping_address"],
						"address_two" => $post["shipping_address_two"],
						"state" => $post["shipping_state"],
						"city" => $post["shipping_city"],
						"zipcode" => $post["shipping_zipcode"],
					],
					"billing" => [
						"first_name" => $post["billing_first_name"],
						"last_name" => $post["billing_last_name"],
						"email" => $post["billing_email"],
						"address" => $post["billing_address"],
						"address_two" => $post["billing_address_two"],
						"state" => $post["billing_state"],
						"city" => $post["billing_city"],
						"zipcode" => $post["billing_zipcode"],
					],
				]);
				$this->Order->create($order_items, $addresses, $charge->id, $shipping_fee);
				$this->session->set_flashdata("message", "Thank you for your purchase. Here is your <a href='{$charge->receipt_url}' target='_blank'>receipt</a>");
				redirect("/cart");
				return;
			} catch (\Stripe\Exception\ApiErrorException $e) {
				$this->session->set_flashdata("message", $e->getError()->message);
				$this->session->set_flashdata("message_type", "error");
				redirect("/cart/checkout?{$url_param}");
				return;
			}
		} else {
			$this->session->set_flashdata("message", $result);
			$this->session->set_flashdata("message_type", "error");
			redirect("/cart/checkout?{$url_param}");
			return;
		}
	}


	public function add() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) return; 

		$post = $this->input->post(null, true);
		$product = $this->Product->get_by_id($post["product_id"]);
		$data = [];
		if(empty($product)) {
			$status = 404;
			$response = "Product Not Found";
		} else if ($post["quantity"] <= 0 || $post["quantity"] > $product["stock"]) {
			$status = 500;
			$response = "Invalid Product Quantity";
		} else {
			$cart_item = $this->Cart->get_item($user["id"], $product["id"]);
			if (!empty($cart_item)) {
				$total_quantity = $cart_item["quantity"] + $post["quantity"];
				$status = 200;
				$result = $this->Cart->update($total_quantity, $cart_item["id"]);
				$response = "{$post["quantity"]} {$product["name"]} has been successfully added to cart";
			} else {
				$result = $this->Cart->create($post["quantity"], $product["id"], $user["id"]);
				if ($result) {
					$status = 200;
					$response = "{$post["quantity"]} {$product["name"]} has been successfully added to cart";
					$data = ["count" => count($this->Cart->get_user_items($user["id"]))];
				} else {
					$status = 500;
					$response = "Failed to add {$post["quantity"]} {$product["name"]}";
				}
			}
		}
		echo json_encode([
			"status" => $status,
			"message" => $response,
			"data" => $data,
			"token" => $this->security->get_csrf_hash(),
		]);
	}

	public function remove($cart_id) {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) return; 

		$cart_item = $this->Cart->get_by_id($cart_id);
		$new_token = $this->security->get_csrf_hash();
		if(empty($cart_item)) {
			echo json_encode([
				"status" => 404,
				"message" => "Cart Item not Found.",
				"token" => $new_token
			]);
			return;
		}
		$this->Cart->delete($cart_id);
		$items = $this->Cart->get_user_items($user["id"]);
		echo json_encode([
			"status" => 200,
			"message" => "{$cart_item["name"]} has been removed from your cart.",
			"data" => [
				"items" => $this->load->view("__partials/cart/index", ["items" => $items], true),
				"count" => count($items),
			],
			"token" => $new_token,
		]);
	}

	public function edit($cart_id) {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) return; 
		$post = $this->input->post(null, true);

		$quantity = $this->input->post("quantity", true);
		$cart_item = $this->Cart->get_by_id($cart_id);
		$new_token = $this->security->get_csrf_hash();
		$selected_items = $this->input->post("cart_items", true);
		if(empty($cart_item)) {
			echo json_encode([
				"status" => 404,
				"message" => "Cart Item not Found.",
				"token" => $new_token
			]);
			return;
		}
		if ($quantity <= 0 || $quantity > $cart_item["stock"]) {
			echo json_encode([
				"status" => 500,
				"message" => "Invalid Product Quantity",
				"token" => $new_token
			]);
			return;
		} 
		$this->Cart->update($quantity, $cart_id);
		$total = (!empty($selected_items)) ? number_format($this->Cart->calculate_total_price($selected_items), 2) : 0;
		echo json_encode([
			"status" => 200,
			"message" => "{$quantity} {$cart_item["name"]} has been successfully added to cart",
			"data" => [
				"item_total_price" => number_format($quantity * $cart_item["price"], 2),
				"total_price" => $total
			],
			"token" => $new_token,
		]);
	}

	public function list_html() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) return;
		$items = $this->Cart->get_user_items($user["id"]);
		echo json_encode([
			"data" => [
				"items" => $this->load->view("__partials/cart/index",[ "items" => $items ], true),
				"count" => count($items),
			]
		]);
	}
	public function remove_html($cart_id) {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) return;

		$cart_item = $this->Cart->get_by_id($cart_id);
		if(empty($cart_item)) return;
		echo json_encode([
			"data" => $this->load->view("__partials/cart/remove", $cart_item, true),
		]);
	}

	public function total() {
		$cart_items = $this->input->post("cart_items", true) ?? [];
		$total = (empty($cart_items)) ? 0 : number_format($this->Cart->calculate_total_price($cart_items), 2);
		echo json_encode([
			"status" => 200,
			"data" => [
				"total" => $total,
				"cart_items" => $this->input->post(null, true),
			],
			"token" => $this->security->get_csrf_hash(),
		]);
	}

	// NOTE: FORM VALIDATION's CUSTOM CALLBACK FUNCTIONS
	// The functions below are for form_validation
	// All of the functions below are remove from the route
	public function valid_name($name) {
		// NOTE: Custom callback function normally overrides the required callback of CodeIgniter
		// This line is a workaround to prevent custom callback to trigger
		if (strlen($name) == 0) return true;

		// Check if the string contains characters other than alphabetic or space character
		foreach(str_split($name) as $char) {
			if(!ctype_alpha($char) && $char != " ") {
				$this->form_validation->set_message("valid_name", "{field} must only contain alphabetic characters.");
				return false;
			}
		}
		return true;
	}
	public function valid_email($email) {
		// NOTE: Custom callback function normally overrides the required callback of CodeIgniter
		// This line is a workaround to prevent custom callback to trigger
		if (strlen($email) == 0) return true;

		// NOTE: For this context, an email with only one @ symbol would be valid
		$email = explode("@", $email);
		if (count($email) != 2) return false;

		// NOTE: Check if the domain for the email is valid
		// For this context, Email domain must contain 1 and only 1 'dot' character('.')
		$email = explode(".", $email[1]);
		if (count($email) != 2) return false;

		return true;
	}
}
