<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Replies extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Reply");
		$this->load->model("Review");
	}

	// TODO: Finish Create Reply
	public function create(int $review_id) {
		$review = $this->Review->get_by_id($review_id);
		if (!empty($review)) {
			$result = $this->Reply->validate();
			if ($result == "valid") {
				$message = "";
				$post = $this->input->post("message", true);
				$this->Reply->create($post, $review_id);
			} else {
				$message = $result;
				$this->session->set_flashdata("message_type", "error");
			}
		} else {
			$message = "Not a valid Review ID.";
			$this->session->set_flashdata("message_type", "error");
		}
		$this->session->set_flashdata("message", $message);
		redirect("/products/show/{$review["product_id"]}");
	}

	public function valid_review_id($review_id) { 
		if (strlen($review_id) == 0) return true;
		return !empty($this->Review->get_by_id($review_id));
   	}
}
