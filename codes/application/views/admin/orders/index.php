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
						<td><?= $order["user_name"] ?></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><?= $order["addresses"]["billing"]["address"] ?></td>
					</tr>
					<tr>
						<td>State</td>
						<td><?= $order["addresses"]["billing"]["state"] ?></td>
					</tr>
					<tr>
						<td>City</td>
						<td><?= $order["addresses"]["billing"]["city"] ?></td>
					</tr>
					<tr>
						<td>Zipcode</td>
						<td><?= $order["addresses"]["billing"]["zipcode"] ?></td>
					</tr>
				</table>
			</div><!--
			--><div class="order-shipping-address">
				<h2 class="">Shipping Address Info:</h2>
				<table>
					<tr>
						<td>Customer Name:</td>
						<td><?= "{$order["addresses"]["shipping"]["first_name"]} {$order["addresses"]["shipping"]["last_name"]}" ?></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><?= $order["addresses"]["shipping"]["address"] ?></td>
					</tr>
					<tr>
						<td>State</td>
						<td><?= $order["addresses"]["shipping"]["state"] ?></td>
					</tr>
					<tr>
						<td>City</td>
						<td><?= $order["addresses"]["shipping"]["city"] ?></td>
					</tr>
					<tr>
						<td>Zipcode</td>
						<td><?= $order["addresses"]["shipping"]["zipcode"] ?></td>
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
					<td>$ <?= number_format($item["price"], 2) ?></td>
					<td><?= $item["quantity"] ?></td>
					<td>$ <?= number_format($item_total, 2) ?></td>
				</tr>
<?php		} ?>
			</tbody>
		</table>
<?php if (!empty($receipt_url)) { ?>
		<div class="text-right mt-md">
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
			<a class="btn btn-md btn-outline-secondary" href="<?= $receipt_url ?>" target="_blank">Receipt</a>
		</div>
<?php } ?>
		<div class="order-description">
			<table class="order-price-table">
				<tr>
					<td>Merchandise Subtotal</td>
					<td><?= number_format($sub_total, 2) ?></td>
				</tr>
				<tr>
					<td>Shipping Fee</td>
					<td><?= number_format($order["shipping_fee"], 2) ?></td>
				</tr>
				<tr class="text-bold">
					<td>Order Total</td>
					<td><?= number_format($sub_total + $order["shipping_fee"], 2) ?></td>
				</tr>
			</table>
		</div>
			
