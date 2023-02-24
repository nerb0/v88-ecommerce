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

	public function get_all($limit = 0) {
		$limit_query = (!empty($limit)) ? "LIMIT ?" : "";
		$query = "SELECT * FROM categories {$limit_query}";
		return $this->db->query($query, [$limit])->result_array();
	}

	public function create($category_name) {
		$query = "INSERT INTO categories(name) VALUES(?)";
		$result =  $this->db->query($query, [$category_name]);
		return $this->db->insert_id();
	}

	public function update($category_id, $name) {
		$query = "UPDATE categories SET name = ? WHERE id = ?";
		$result =  $this->db->query($query, [$name, $category_id]);
		return $result;
	}

	public function delete_not_in_list($category_list) {
		$query = "DELETE FROM categories WHERE id NOT IN ?";
		$result =  $this->db->query($query, [$category_list]);
		return $result;
	}
}
