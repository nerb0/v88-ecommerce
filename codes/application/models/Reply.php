<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reply extends CI_Model {
	public function get_grouped_by_product_id($product_id) {
		$query = "SELECT replies.*
					,CONCAT_WS(' ', first_name, last_name) as user_name
					,reviews.id as review_id
						FROM replies INNER JOIN reviews
							ON review_id = reviews.id
						INNER JOIN products
							ON product_id = products.id
						INNER JOIN users
							ON replies.user_id = users.id
						WHERE product_id = ?
						ORDER BY replies.created_at DESC";
		$result = $this->db->query($query, [$product_id])->result_array();
		$grouped_result = array_reduce($result, function($res, $reply) {
			$res[$reply["review_id"]][] = $reply;
			return $res;
		}, []);
		return $grouped_result;
	}

	public function get_by_id($reply_id) {
		$query = "SELECT * FROM replies WHERE id = ?";
		$result = $this->db->query($query, [$reply_id] )->row_array();
		return $result;
	}

	public function create($message, $review_id) {
		$user_id = $this->session->userdata("user_id");
		$query = "INSERT INTO replies(message, user_id, review_id) VALUES(?,?,?)";
		$result = $this->db->query($query, [$message, $user_id, $review_id]);
		return $this->db->insert_id();
	}

	public function validate() {
		$this->form_validation->set_rules("message", "Reply Message", "trim|required|min_length[10]|max_length[400]");
		$this->form_validation->set_message("valid_review", "Not a valid Review ID.");
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}
}
