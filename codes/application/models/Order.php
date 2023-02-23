<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model {
	const STATUS = [ "Processing", "To Ship", "Shipping", "Cancelled", "Delivered" ];
	const ROW_LIMIT = 15;
	const SHIPPING_FEE = 24;

	public function get($filter = []) {
		$conditions = [];
		$values = [];
		if (!empty($filter["search"])) {
			$values[] = "%{$filter["search"]}%";
			$conditions[] = "CONCAT(orders.id, users.first_name, users.last_name, addresses, orders.created_at) LIKE ?";
		}
		if (!empty($filter["status"])) {
			$conditions[] = "status = ?";
			$values[] = $filter["status"];
		}
		$where = (!empty($conditions)) ? "WHERE " . implode(" AND ", $conditions) : "";
		$query = "SELECT orders.*
					,CONCAT_WS(' ',users.first_name, users.last_name) as user_name
						FROM orders LEFT JOIN users ON user_id = users.id
						{$where} GROUP BY orders.id";
		return $this->db->query($query, $values)->result_array();
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
		$result = $this->db->query($query, [$order_id])->row_array();
		return $result;
	}

	public function create($order_items, $addresses, $charge_id, $shipping_fee) {
		$user_id = $this->session->userdata("user_id");
		$query = "INSERT INTO orders(user_id, order_items, addresses, charge_id, shipping_fee) VALUE(?,?,?,?,?)";
		$result =  $this->db->query($query, [$user_id ,$order_items, $addresses, $charge_id, $shipping_fee]);
		return $result;
	}

	public function update($order_id, $status) {
		$query = "UPDATE orders SET status = ? WHERE id = ?";
		$result = $this->db->query($query, [$status, $order_id]);
		return $result;
	}
}
