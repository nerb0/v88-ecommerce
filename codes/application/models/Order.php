<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model {
	const STATUS = [ "Processing", "To Ship", "Shipping", "Cancelled", "Delivered" ];
	const ROW_LIMIT = 15;

	public function get($page = 1, $filter = []) {
		if ($page > $this->get_total_pages()) return false;

		$query = "SELECT orders.*
					,CONCAT_WS(' ',users.first_name, users.last_name) as user_name
						FROM orders LEFT JOIN users ON user_id = users.id
						GROUP BY orders.id";
		$result = $this->db->query($query)->result_array();
		$start = ($page - 1) * self::ROW_LIMIT;
		return array_slice($result, $start, self::ROW_LIMIT);
	}

	public function get_total_pages() {
		$query = "SELECT * FROM orders";
		$result = $this->db->query($query)->result_array();
		return ceil(count($result) / self::ROW_LIMIT);
	}

	public function get_by_id($order_id) {
		$query = "SELECT orders.*
					,CONCAT_WS(' ',users.first_name, users.last_name) as user_name
						FROM orders LEFT JOIN users ON user_id = users.id
						WHERE orders.id = ?
						GROUP BY orders.id";
		return $this->db->query($query, [$order_id])->row_array();
	}
}
