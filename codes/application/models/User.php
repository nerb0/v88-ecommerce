<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
	const ERRORS = [
		"login" => "<p>Incorrect User Email Address or Password</p>"
	];
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
		"password" => [
			"field" => "password",
			"label" => "Password",
			"rules" => "required|min_length[8]|max_length[16]",
		],
		"confirm_password" => [
			"field" => "confirm_password",
			"label" => "Confirm Password",
			"rules" => "required|min_length[8]|max_length[16]|matches[password]",
		],
		"login_email" => [
			"field" => "email",
			"label" => "Email Address",
			"rules" => "required|min_length[8]|callback_valid_email|callback_valid_login",
			"errors" => [
				"valid_login" => "Incorrect Email Address or Password"
			]
		],
		"email" => [
			"field" => "email",
			"label" => "Email Address",
			"rules" => "required|min_length[8]|callback_valid_email|callback_email_exists",
			"errors" => [
				"valid_email" => "Email Address is in invalid format.",
				"email_exists" => "Email Address is already used."
			]
		],
		"new_password" => [
			"field" => "new_password",
			"label" => "New Password",
			"rules" => "required|min_length[8]|max_length[16]|callback_valid_new_password",
			"errors" => [
				"valid_new_password" => "New Password cannot be the same as your old password."
			]
		],
		"confirm_new_password" => [
			"field" => "confirm_password",
			"label" => "Confirm Password",
			"rules" => "required|min_length[8]|max_length[16]|matches[new_password]",
		],
		"old_password" => [
			"field" => "old_password",
			"label" => "Old Password",
			"rules" => "required|min_length[8]|max_length[16]|callback_valid_old_password",
			"errors" => [
				"valid_old_password" => "Your password is incorrect."
			]
		],
		"address_email" => [
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
	
	public function get_by_email($email) {
		$query = "SELECT * FROM users WHERE email = ?";
		return $this->db->query($query, [$email])->row_array();
	}

	public function get_by_session() {
		$user_id = $this->session->userdata("user_id");
		$query = "SELECT * FROM users WHERE id = ?";
		return $this->db->query($query, [$user_id])->row_array();
	}

	public function get_by_id($user_id) {
		$query = "SELECT * FROM users WHERE id = ?";
		return $this->db->query($query, [$user_id])->row_array();
	}

	public function list_address() {
		$user_id = $this->session->userdata("user_id");
		$query = "SELECT * FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC";
		return $this->db->query($query, [$user_id])->result_array();
	}

	public function get_default_address() {
		$user_id = $this->session->userdata("user_id");
		$query = "SELECT * FROM user_addresses WHERE user_id = ? AND is_default = 1";
		return $this->db->query($query, [$user_id])->row_array();
	}

	public function create($user) {
		$salt = bin2hex(openssl_random_pseudo_bytes(26));
		$encrypted_password = md5($user["password"] . $salt);
		$query = "INSERT INTO users(first_name, last_name, email, password, salt) VALUES(?,?,?,?,?)";
		$result = $this->db->query($query, [
			$user["first_name"],
			$user["last_name"],
			$user["email"],
			$encrypted_password,
			$salt
		]);
		return $this->db->insert_id();
	}

	public function update($user) {
		$user_id = $this->session->userdata("user_id");
		$query = "UPDATE users
					SET first_name = ?
						,last_name = ?
						,email = ?
						,updated_at = NOW()
					WHERE id = ?";
		$result = $this->db->query($query, [
			$user["first_name"],
			$user["last_name"],
			$user["email"],
			$user_id
		]);
		return $result;
	}

	public function update_with_password($user) {
		$user_id = $this->session->userdata("user_id");
		$query = "UPDATE users
					SET first_name = ?
						,last_name = ?
						,email = ?
						,password = ?
						,updated_at = NOW()
					WHERE id = ?";
		$result = $this->db->query($query, [
			$user["first_name"],
			$user["last_name"],
			$user["email"],
			$user["new_password"],
			$user_id
		]);
		return $result;
	}

	public function add_address($address) {
		$user_id = $this->session->userdata("user_id");
		$default = (!empty($this->list_address())) ? 0 : 1;
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
	}

	public function validate_address() {
		$rules = [
			self::RULES["first_name"],
			self::RULES["last_name"],
			self::RULES["address_email"],
			self::RULES["address"],
			self::RULES["address_two"],
			self::RULES["state"],
			self::RULES["city"],
			self::RULES["zipcode"],
		];
		return $this->validate($rules);
	}
	
	public function validate_profile($change_password) {
		$rules = [
			self::RULES["first_name"],
			self::RULES["last_name"],
			self::RULES["email"],
		];
		if (!empty($change_password)) {
			array_push($rules, ...[
				self::RULES["old_password"],
				self::RULES["new_password"],
				self::RULES["confirm_new_password"],
			]);
		}
		return $this->validate($rules);
	}

	public function validate_login() {
		$rules = [
			self::RULES["login_email"],
			self::RULES["password"]
		];
		return $this->validate($rules);
	}

	public function validate_register($post) {
		$rules = [
			self::RULES["first_name"],
			self::RULES["last_name"],
			self::RULES["email"],
			self::RULES["password"],
			self::RULES["confirm_password"],
		];
		return $this->validate($rules);
	}

	private function validate($rules, $data = []) {
		$this->form_validation->set_rules($rules);
		if (!empty($data)) $this->form_validation->set_data($data);
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}
}
