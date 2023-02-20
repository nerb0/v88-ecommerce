<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Model {
	public function get_by_name($category_name) {
		$query = "SELECT * FROM categories WHERE name = ?";
		return $this->db->query($query, [$category_name])->row_array();
	}

	public function get_by_id($category_id) {
		$query = "SELECT * FROM categories WHERE id = ?";
		return $this->db->query($query, [$category_id])->row_array();
	}

	public function get_all() {
		$query = "SELECT * FROM categories";
		return $this->db->query($query)->result_array();
	}

	public function create($category_name) {
		$query = "INSERT INTO categories(name) VALUES(?)";
		$result =  $this->db->query($query, [$category_name]);
		return $this->db->insert_id();
	}
}
