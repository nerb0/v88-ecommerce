<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("User");
	}

	public function index() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		$this->load->model("Cart");
		$this->load->model("Product");
		$this->load->model("Category");
		$view_data = [
			"products/home" => [
				"user" => $user,
				"categories" => $this->Category->get_all(5),
				"banner_products" => $this->Product->get_banner(),
				"featured_products" => $this->Product->get_featured(),
			]
		];
		$header_data = [
			"links" => [
				"Home" => "#",
				"Catalog" => "/products/catalog",
			],
			"include" => [
				"js" => [],
				"css" => [],
			],
			"cart_count" => count($this->Cart->get_user_items($user["id"])),
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user
		];
		render_html($this, $view_data, $header_data);
	}

	public function login() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(!empty($user)) {
			redirect('/home');
		}
		$view_data = [
			"users/login" => []
		];
		$header_data = [
			"include" => [
				"js" => [],
				"css" => [],
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
		];
		render_html($this, $view_data, $header_data);
	}
	public function process_login() {
		$post = $this->input->post(null, true);
		$result = $this->User->validate_login();
		if ($result == "valid") {
			$user = $this->User->get_by_email($post["email"]);
			$this->session->set_userdata("user_id", $user["id"]);
			redirect("/home");
		} else {
			$this->session->set_flashdata("message", $result);
			$this->session->set_flashdata("message_type", "error");
			redirect("/login");
		}
	}

	public function register() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(!empty($user)) {
			redirect('/home');
		}
		$view_data = [
			"users/register" => []
		];
		$header_data = [
			"include" => [
				"js" => [],
				"css" => [],
			],
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
		];
		render_html($this, $view_data, $header_data);
	}
	public function process_register() {
		$post = $this->input->post(null, true);
		$result = $this->User->validate_register($post);
		if ($result == "valid") {
			$user_id = $this->User->create($post);
			$this->session->set_userdata("user_id", $user_id);
			redirect("/home");
		} else {
			$this->session->set_flashdata("message", $result);
			$this->session->set_flashdata("message_type", "error");
			redirect("/register");
		}
	}

	public function profile() {
		$this->load->model("Cart");
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		$view_data = [
			"users/profile" => [
				"user" => $user,
				"addresses" => $this->User->list_address(),
				"fields" => $this->session->flashdata("fields"),
			]
		];
		$header_data = [
			"links" => [
				"Home" => "/home",
				"Catalog" => "/products/catalog",
			],
			"include" => [
				"js" => [],
				"css" => [],
			],
			"cart_count" => count($this->Cart->get_user_items($user["id"])),
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
			"user" => $user,
		];
		render_html($this, $view_data, $header_data);
	}
	public function edit_profile() {
		$user = $this->User->get_by_session();
		if (empty($user)) {
			redirect("/login");
		}
		$post = $this->input->post(null, true);
		$result = $this->User->validate_profile($post["change_password"]);
		if ($result == "valid") {
			if (empty($post["change_password"])) {
				$this->User->update($post);
			} else {
				$this->User->update_with_password($post);
			}
			$message = "Profile Information has been successfully updated.";
			$type = "";
		} else {
			$message = $result;
			$type = "error";
		}
		$this->session->set_flashdata("message", $message);
		$this->session->set_flashdata("message_type", $type);
		redirect("/users/profile");
	}

	public function add_address() {
		$post = $this->input->post(null, true);
		$result = $this->User->validate_address();
		if ($result == "valid") {
			$this->User->add_address($post);
			$message = "Address has been successfully added.";
			$type = "";
			$fields = [];
		} else {
			$message = $result;
			$type = "error";
			$fields = $post;
		}
		$this->session->set_flashdata("message", $message);
		$this->session->set_flashdata("message_type", $type);
		$this->session->set_flashdata("fields", $fields);
		redirect("/users/profile");
	}

	public function logout() {
		$this->session->unset_userdata("user_id");
		redirect('/login');
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
	public function email_exists($email) {
		// NOTE: Custom callback function normally overrides the required callback of CodeIgniter
		// This line is a workaround to prevent custom callback to trigger
		if (strlen($email) == 0) return true;

		$user = $this->User->get_by_email($email);
		if(!empty($user)) {
			return $user["id"] == $this->session->userdata("user_id");
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
	public function valid_login($email) {
		// NOTE: Custom callback function normally overrides the required callback of CodeIgniter
		// This line is a workaround to prevent custom callback to trigger
		$password = $this->input->post("password", true);
		if(strlen($password) == 0) return true;
		if(strlen($email) == 0) return true;

		$user = $this->User->get_by_email($email);
		if (empty($user)) return false;

		$encrypted_password = md5($password . $user["salt"]);
		return $encrypted_password == $user["password"];
	}
	public function valid_new_password($new_password) {
		if (strlen($new_password) == 0) return true;

		$user = $this->User->get_by_session();
		if(!empty($user)) {
			$encrypted_password = md5($new_password . $user["salt"]);
			return $encrypted_password != $user["password"];
		}
		return false;
	}
	public function valid_old_password($old_password) {
		if (strlen($old_password) == 0) return true;

		$user = $this->User->get_by_session();
		if(!empty($user)) {
			$encrypted_password = md5($old_password . $user["salt"]);
			return $encrypted_password == $user["password"];
		}
		return false;
	}
}
