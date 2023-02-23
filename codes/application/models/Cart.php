<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Model {
	const RULES = [
		"shipping_first_name" => [
			"field" => "shipping_first_name",
			"label" => "Shipping First Name",
			"rules" => "required|callback_valid_name",
		],
		"shipping_last_name" => [
			"field" => "shipping_last_name",
			"label" => "Shipping Last Name",
			"rules" => "required|callback_valid_name",
		],
		"shipping_email" => [
			"field" => "shipping_email",
			"label" => "Shipping Email Address",
			"rules" => "required|min_length[8]|callback_valid_email",
			"errors" => [
				"valid_email" => "Email Address is in invalid format.",
			]
		],
		"shipping_address" => [
			"field" => "shipping_address",
			"label" => "Shipping Address 1",
			"rules" => "trim|required|min_length[8]",
		],
		"shipping_address_two" => [
			"field" => "shipping_address_two",
			"label" => "Address 2",
			"rules" => "trim",
		],
		"shipping_state" => [
			"field" => "shipping_state",
			"label" => "Shipping State",
			"rules" => "required|max_length[48]",
		],
		"shipping_city" => [
			"field" => "shipping_city",
			"label" => "Shipping City",
			"rules" => "required|max_length[58]",
		],
		"shipping_zipcode" => [
			"field" => "shipping_zipcode",
			"label" => "Shipping Zipcode",
			"rules" => "required|max_length[10]",
		],
		"billing_first_name" => [
			"field" => "billing_first_name",
			"label" => "Billing First Name",
			"rules" => "required|callback_valid_name",
		],
		"billing_last_name" => [
			"field" => "billing_last_name",
			"label" => "Billing Last Name",
			"rules" => "required|callback_valid_name",
		],
		"billing_email" => [
			"field" => "billing_email",
			"label" => "Billing Email Address",
			"rules" => "required|min_length[8]|callback_valid_email",
			"errors" => [
				"valid_email" => "Email Address is in invalid format.",
			]
		],
		"billing_address" => [
			"field" => "billing_address",
			"label" => "Billing Address 1",
			"rules" => "trim|required|min_length[8]",
		],
		"billing_address_two" => [
			"field" => "billing_address_two",
			"label" => "Billing Address 2",
			"rules" => "trim",
		],
		"billing_state" => [
			"field" => "billing_state",
			"label" => "Billing State",
			"rules" => "required|max_length[48]",
		],
		"billing_city" => [
			"field" => "billing_city",
			"label" => "Billing City",
			"rules" => "required|max_length[58]",
		],
		"billing_zipcode" => [
			"field" => "billing_zipcode",
			"label" => "Billing Zipcode",
			"rules" => "required|max_length[10]",
		],
		"card_expiry" => [
			"field" => "card_expiry",
			"label" => "Card Expiry ",
			"rules" => "required",
		],
		"card_number" => [
			"field" => "card_number",
			"label" => "Card Number ",
			"rules" => "required",
		],
		"card_cvc" => [
			"field" => "card_cvc",
			"label" => "Card CVC ",
			"rules" => "required",
		],
	];
	public function get_by_id($cart_id) {
		$query = "SELECT cart_items.*
					,name
					,price
					,stock
					,images->>\"$.main\" as image
					FROM cart_items INNER JOIN products
						ON product_id = products.id
					WHERE cart_items.id = ?";
		return $this->db->query($query, [$cart_id])->row_array();
	}

	public function get_item($user_id, $product_id) {
		$query = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?";
		return $this->db->query($query, [$user_id, $product_id])->row_array();
	}
	
	public function get_selected_items($selected_items) {
		$query = "SELECT cart_items.*
					,name
					,price
					,stock
					,images->>\"$.main\" as image
					FROM cart_items INNER JOIN products
						ON product_id = products.id
					WHERE cart_items.id IN ?";
		return $this->db->query($query, [$selected_items])->result_array();
	}
	
	public function get_user_items($user_id) {
		$query = "SELECT cart_items.*
					,price
					,name
					,stock
					,images->>\"$.main\" as image
					FROM cart_items INNER JOIN products
						ON product_id = products.id
					WHERE user_id = ?";
		return $this->db->query($query, [$user_id])->result_array();
	}

	public function calculate_total_price($items) {
		$user_id = $this->session->userdata("user_id");
		$query = "SELECT SUM(price * quantity) as total_price
					FROM cart_items INNER JOIN products
						ON product_id = products.id
					WHERE user_id = ? AND cart_items.id IN ?
					GROUP BY user_id";
		return $this->db->query($query, [$user_id, $items])->row_array()["total_price"];

	}

	public function create($quantity, $product_id, $user_id) {
		$query = "INSERT INTO cart_items(quantity, product_id, user_id) VALUES(?,?,?)";
		$result =  $this->db->query($query, [$quantity, $product_id, $user_id]);
		return $this->db->insert_id();
	}

	public function delete($cart_id) {
		$query = "DELETE FROM cart_items WHERE id = ?";
		$result =  $this->db->query($query, [$cart_id]);
		return $result;
	}

	public function update($quantity, $cart_id) {
		$query = "UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?";
		$result =  $this->db->query($query, [
			$quantity,
			$cart_id
		]);
		return $result;
	}

	public function validate() {
		$rules = [
			self::RULES["shipping_first_name"],
			self::RULES["shipping_last_name"],
			self::RULES["shipping_email"],
			self::RULES["shipping_address"],
			self::RULES["shipping_address_two"],
			self::RULES["shipping_city"],
			self::RULES["shipping_state"],
			self::RULES["shipping_zipcode"],
			self::RULES["billing_first_name"],
			self::RULES["billing_last_name"],
			self::RULES["billing_email"],
			self::RULES["billing_address"],
			self::RULES["billing_address_two"],
			self::RULES["billing_city"],
			self::RULES["billing_state"],
			self::RULES["billing_zipcode"],
			self::RULES["card_expiry"],
			self::RULES["card_number"],
			self::RULES["card_cvc"],
		];
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}
}
