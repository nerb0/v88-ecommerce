<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addresses extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("User");
		$this->load->model("Address");
	}

	public function create() {
		$user = $this->User->get_by_session();
		if (empty($user)) {
			redirect("/login");
			return;
		}
		$post = $this->input->post(null, true);
		$result = $this->Address->validate();
		if ($result == "valid") {
			$this->Address->create($post);
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
	public function update(int $address_id) {
		$user = $this->User->get_by_session();
		if (empty($user)) {
			redirect("/login");
			return;
		}
		$post = $this->input->post(null, true);
		if (empty($address_id)) return;
		$address = $this->Address->get_by_id($address_id);
		$result = $this->Address->validate();
		if ($result == "valid" && !empty($address)) {
			$this->Address->update($address_id, $post);
			echo json_encode([
				"status" => 200,
				"message" => "Address has been successfully edited.",
				"data" => [
					"view" => $this->load->view("__partials/shipping_card", $this->Address->get_by_id($address_id), true)
				]
			]);
		} else {
			echo json_encode([
				"status" => 500,
				"message" => $result,
			]);
		}
	}
	public function set_default(int $address_id) {
		$user = $this->User->get_by_session();
		if (empty($user)) {
			redirect("/login");
			return;
		}
		$post = $this->input->post(null, true);
		if (empty($address_id)) return;
		$address = $this->Address->get_by_id($address_id);
		if (!empty($address)) {
			$this->Address->set_default($address_id);
			echo json_encode([
				"status" => 200,
				"message" => "Address has been set as Default Address",
				"data" => [
					"view" => $this->load->view("__partials/shipping_cards", ["addresses" => $this->Address->list_by_user()], true)
				]
			]);
		} else {
			echo json_encode([
				"status" => 404,
				"message" => "Address cannot be found.",
			]);
		}
	}

	public function edit_html($address_id) {
		$user = $this->User->get_by_session();
		if (empty($user)) {
			redirect("/login");
			return;
		}
		if (empty($address_id)) {
			echo json_encode([
				"status" => 500,
				"message" => "Please select an appropriate address.",
			]);
		}
		$address = $this->Address->get_by_id($address_id);
		if (empty($address)) {
			echo json_encode([
				"status" => 404,
				"message" => "User Address cannot be found."
			]);
		} else {
			echo json_encode([
				"status" => 200,
				"data" => [
					"view" => $this->load->view("__partials/address", $address, true)
				]
			]);
		}
	}
	public function get_json($address_id) {
		$user = $this->User->get_by_session();
		if (empty($user)) {
			redirect("/login");
			return;
		}
		if (empty($address_id)) {
			echo json_encode([
				"status" => 500,
				"message" => "Please select an appropriate address.",
			]);
		}
		$address = $this->Address->get_by_id($address_id);
		if (empty($address)) {
			echo json_encode([
				"status" => 404,
				"message" => "User Address cannot be found."
			]);
		} else {
			echo json_encode([
				"status" => 200,
				"data" => $address
			]);
		}
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
