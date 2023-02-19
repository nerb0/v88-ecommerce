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
			"rules" => "required|min_length[8]|callback_valid_email",
			"errors" => [
				"valid_email" => "Email Address is in invalid format."
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
				"valid__password" => "Your password is incorrect."
			]
		],
	];
	
	public function get_by_email($email) {
		$query = "SELECT * FROM users WHERE email = ?";
		return $this->db->query($query, [$email])->row_array();
	}

	public function get_by_id($user_id) {
		$query = "SELECT * FROM users WHERE id = ?";
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

	public function validate_login() {
		$rules = [
			self::RULES["login_email"],
			self::RULES["password"]
		];
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}

	public function validate_register($post) {
		$rules = [
			self::RULES["first_name"],
			self::RULES["last_name"],
			self::RULES["email"],
			self::RULES["password"],
			self::RULES["confirm_password"],
		];
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}
}
