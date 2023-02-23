<table class="admin-list">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Date</th>
			<th>Billing Address</th>
			<th>Total Price</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($orders as $order) {
		$date_created = date_format(date_create($order["created_at"]), "Y/m/d");
		$billing_address = json_decode($order["addresses"], true)["billing"]["address"];
		$total_price = array_reduce(json_decode($order["order_items"], true), function($res, $product) {
			return $product["price"] * $product["quantity"] + $res;
		}, 0) + $order["shipping_fee"];
?>
		<tr>
			<td class="id"><a href="/admin/orders/show/<?= $order["id"] ?>"><?= $order["id"] ?></a></td>
			<td><?= $order["user_name"] ?></td>
			<td><?= $date_created ?></td>
			<td><?= $billing_address ?></td>
			<td>$ <?= number_format($total_price, 2) ?></td>
			<td>
				<form action="/orders/edit/<?= $order["id"] ?>">
					<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
					<select name="status" class="order-edit-status btn btn-md btn-outline-secondary">
<?php				foreach ($statuses as $status) {
						$is_selected = ($status == $order["status"]) ? "selected" : "";
?>
						<option <?= $is_selected ?> value="<?= $status ?>"><?= $status ?></option>
<?php				} ?>
					</select>
				</form>
			</td>
		</tr>
<?php } ?>
	</tbody>
</table>
