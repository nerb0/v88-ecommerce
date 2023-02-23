<?php defined('BASEPATH') OR exit('No direct script access allowed');
	$sub_total = 0;
	?>
		<h2 class="text-center">Order ID #<?= $order["id"] ?></h2>
		<div class="order-address-group">
			<div class="order-billing-address">
				<h2 class="">Billing Address Info:</h2>
				<table>
					<tr>
						<td>Customer Name:</td>
						<td>name</td>
					</tr>
					<tr>
						<td>Address:</td>
						<td>123 Address asdasdasdas</td>
					</tr>
					<tr>
						<td>State</td>
						<td>TEst State</td>
					</tr>
					<tr>
						<td>City</td>
						<td>TEst City</td>
					</tr>
					<tr>
						<td>Zipcode</td>
						<td>98133</td>
					</tr>
				</table>
			</div><!--
			--><div class="order-shipping-address">
				<h2 class="">Shipping Address Info:</h2>
				<table>
					<tr>
						<td>Customer Name:</td>
						<td>name</td>
					</tr>
					<tr>
						<td>Address:</td>
						<td>123 Address asdasdasdas</td>
					</tr>
					<tr>
						<td>State</td>
						<td>TEst State</td>
					</tr>
					<tr>
						<td>City</td>
						<td>TEst City</td>
					</tr>
					<tr>
						<td>Zipcode</td>
						<td>98133</td>
					</tr>
				</table>
			</div>
		</div>
		<table class="order-item-list admin-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>Item</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
<?php		foreach (json_decode($order["order_items"], true) as $id => $item) {
				$item_total = $item["price"] * $item["quantity"];
				$sub_total += $item_total;
?>
				<tr>
					<td><?= $id ?></td>
					<td><?= $item["name"] ?></td>
					<td><?= $item["price"] ?></td>
					<td><?= $item["quantity"] ?></td>
					<td><?= $item_total ?></td>
				</tr>
<?php		} ?>
			</tbody>
		</table>
		<div class="text-right order-description">
			<form action="/orders/edit/<?= $order["id"] ?>" class="order-status-form">
				<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
				<select name="status" class="order-edit-status btn btn-md btn-outline-secondary">
<?php			foreach ($statuses as $status) {
					$is_selected = ($status == $order["status"]) ? "selected" : "";
?>
					<option <?= $is_selected ?> value="<?= $status ?>"><?= $status ?></option>
<?php			} ?>
				</select>
			</form>
			<table class="order-price-table">
				<tr>
					<td>Merchandise Subtotal</td>
					<td><?= $sub_total ?></td>
				</tr>
				<tr>
					<td>Shipping Fee</td>
					<td><?= $order["shipping_fee"] ?></td>
				</tr>
				<tr class="text-bold">
					<td>Order Total</td>
					<td><?= $sub_total + $order["shipping_fee"] ?></td>
				</tr>
			</table>
		</div>
