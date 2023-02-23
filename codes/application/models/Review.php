<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Model {
	public function get_by_product_id($product_id) {
		$query = "SELECT reviews.*
					,CONCAT_WS(' ', first_name, last_name) as user_name
						FROM reviews INNER JOIN products
							ON product_id = products.id
						INNER JOIN users
							ON reviews.user_id = users.id
						WHERE product_id = ?
						ORDER BY reviews.created_at DESC";
		$result = $this->db->query($query, [$product_id])->result_array();
		return $result;
	}

	public function get_by_id($review_id) {
		$query = "SELECT * FROM reviews WHERE id = ?";
		$result = $this->db->query($query, [$review_id] )->row_array();
		return $result;
	}

	public function create($message, $product_id) {
		$user_id = $this->session->userdata("user_id");
		$query = "INSERT INTO reviews(message, user_id, product_id) VALUES(?,?,?)";
		$result = $this->db->query($query, [$message, $user_id, $product_id]);
		return $this->db->insert_id();
	}

	public function validate() {
		$this->form_validation->set_rules("message", "Review Message", "trim|required|max_length[400]");
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}
}
