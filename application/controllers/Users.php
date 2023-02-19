<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("User");
	}

	public function index() {
		$user_id = $this->session->userdata("user_id");
		redirect($user_id ? "/dashboard" : "login");
	}

	public function login() {
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(!empty($user)) {
			redirect('/home');
		}
		render_html($this, [
			"users/login" => []
		],[
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
		]);
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
		render_html($this, [
			"users/register" => []
		],[
			"message" => $this->session->flashdata("message"),
			"message_type" => $this->session->flashdata("message_type"),
		]);
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
		$user = $this->User->get_by_id($this->session->userdata("user_id"));
		if(empty($user)) {
			redirect('login');
		}
		render_html($this, [
			"users/profile" => []
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

	public function logout() {
		$this->session->unset_userdata("user_id");
		redirect('/login');
	}

	// NOTE: The functions below are for form_validation
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
}

