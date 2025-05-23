<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends CI_Model {
	const RULES = [
		"first_name" => [
			"field" => "first_name",
			"label" => "First Name",
			"rules" => "required|callback_valid_name",
		],
		"last_name" => [
			"field" => "last_name",
			"label" => "Last Name",
			"rules" => "required|callback_valid_name",
		],
		"email" => [
			"field" => "email",
			"label" => "Email Address",
			"rules" => "required|min_length[8]|callback_valid_email",
			"errors" => [
				"valid_email" => "Email Address is in invalid format.",
			]
		],
		"address" => [
			"field" => "address",
			"label" => "Address 1",
			"rules" => "trim|required|min_length[8]",
		],
		"address_two" => [
			"field" => "address_two",
			"label" => "Address 2",
			"rules" => "trim",
		],
		"state" => [
			"field" => "state",
			"label" => "State",
			"rules" => "required|max_length[48]",
		],
		"city" => [
			"field" => "city",
			"label" => "City",
			"rules" => "required|max_length[58]",
		],
		"zipcode" => [
			"field" => "zipcode",
			"label" => "zipcode",
			"rules" => "required|max_length[10]",
		],
	];
	
	public function list_by_user() {
		$user_id = $this->session->userdata("user_id");
		$query = "SELECT * FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC";
		return $this->db->query($query, [$user_id])->result_array();
	}

	public function get_default() {
		$user_id = $this->session->userdata("user_id");
		$query = "SELECT * FROM user_addresses WHERE user_id = ? AND is_default = 1";
		return $this->db->query($query, [$user_id])->row_array();
	}

	public function set_default($address_id) {
		// NOTE: This is to change the default address back to regular address
		// Since no user can have multiple default address.
		$user_id = $this->session->userdata("user_id");
		$this->db->query("UPDATE user_addresses SET is_default = 0 WHERE user_id = ? AND is_default = 1", [$user_id]);

		$query = "UPDATE user_addresses SET is_default = 1 WHERE id = ?";
		$result = $this->db->query($query, $address_id);
		return $result;
	}

	public function update($address_id, $post) {
		// NOTE: This is to change the default address back to regular address
		// Since no user can have multiple default address.
		$query = "UPDATE user_addresses SET
					first_name = ?
					,last_name = ?
					,email = ?
					,address = ?
					,address_two = ?
					,state = ?
					,city = ?
					,zipcode = ?
					,updated_at = NOW()
				WHERE id = ?";
		$result = $this->db->query($query, [
			$post["first_name"],
			$post["last_name"],
			$post["email"],
			$post["address"],
			$post["address_two"],
			$post["state"],
			$post["city"],
			$post["zipcode"],
			$address_id
		]);
		return $result;
	}
	public function create($address) {
		$user_id = $this->session->userdata("user_id");
		$default = (!empty($this->list_by_user())) ? 0 : 1;
		$query = "INSERT INTO user_addresses(first_name, last_name, email, address, address_two, state, city, zipcode, user_id, is_default) VALUES(?,?,?,?,?,?,?,?,?,?)";
		$result = $this->db->query($query, [
			$address["first_name"],
			$address["last_name"],
			$address["email"],
			$address["address"],
			$address["address_two"],
			$address["state"],
			$address["city"],
			$address["zipcode"],
			$user_id,
			$default
		]);
		return $this->db->insert_id();
	}
	public function get_by_id($address_id) {
		$query = "SELECT * FROM user_addresses WHERE id = ?";
		$result = $this->db->query($query, [$address_id])->row_array();
		return $result;
	}

	public function validate() {
		$rules = [
			self::RULES["first_name"],
			self::RULES["last_name"],
			self::RULES["email"],
			self::RULES["address"],
			self::RULES["address_two"],
			self::RULES["state"],
			self::RULES["city"],
			self::RULES["zipcode"],
		];
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}
}
