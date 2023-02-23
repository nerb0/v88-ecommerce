<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("Review");
	}

	// TODO: Finish Create Review
	public function create(int $product_id) {
		$result = $this->Review->validate();
		if ($result == "valid") {
			$post = $this->input->post(null, true);
			$this->Review->create($post["message"], $product_id);
		} else {
			$this->session->set_flashdata("message", $result);
			$this->session->set_flashdata("message_type", "error");
		}
		redirect("/products/show/{$product_id}");
	}

}
