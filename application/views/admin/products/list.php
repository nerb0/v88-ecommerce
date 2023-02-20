<?php defined('BASEPATH') OR exit('No direct script access allowed');
	?>
		<div class="modal-container hidden" id="modalContainer">
			<div id="modal" class="modal">
			</div>
		</div>
		<form class="order-header" action="/orders/filter">
			<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
			<div class="admin-search">
				<div class="order-search">
					<input type="text" name="search" placeholder="Search" class="input-search btn-outline-secondary" />
					<svg class="search-btn" id="orderSearchBtn" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.5 14.5l-4-4m-4 2a6 6 0 110-12 6 6 0 010 12z"></path>
					</svg>
				</div>
			</div><!--
			--><div class="admin-misc">
				<span id="addProductBtn" class="btn btn-md btn-outline-secondary">Add a New Product</span>
			</div>
		</form>
		<table class="admin-list">
			<thead>
				<tr>
					<th>Picture</th>
					<th class="id">ID</th>
					<th>Name</th>
					<th>Inventory Count</th>
					<th>Product Sold</th>
					<th>Price</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
<?php		foreach ($products as $product) {
				$main_image = json_decode($product["images"], true)["main"];
?>
				<tr>
					<td class="text-center"><img src="<?= $main_image ?>" alt="" class="product-image"/></td>
					<td class="text-center"><?= $product["id"] ?></td>
					<td><?= $product["name"] ?></td>
					<td><?= $product["quantity"] ?></td>
					<td><?= $product["sold"] ?? 0 ?></td>
					<td><?= $product["price"] ?></td>
					<td>
						<span class="btn btn-md btn-outline-secondary product-edit" data-id="<?= $product["id"] ?>">Edit</span>
						<span class="btn btn-md btn-outline-error product-remove" data-id="<?= $product["id"] ?>">Remove</span>
					</td>
				</tr>
<?php		} ?>
			</tbody>
		</table>
