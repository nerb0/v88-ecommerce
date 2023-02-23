<?php defined('BASEPATH') OR exit('No direct script access allowed');
	?>
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
<?php foreach ($products as $product) {
		$main_image = json_decode($product["images"], true)["main"];
?>
		<tr>
			<td class="text-center"><img src="<?= $main_image ?>" alt="" class="product-image"/></td>
			<td class="text-center"><?= $product["id"] ?></td>
			<td><?= $product["name"] ?></td>
			<td><?= $product["stock"] ?></td>
			<td><?= $product["sold"] ?? 0 ?></td>
			<td>$<?= number_format($product["price"], 2) ?></td>
			<td>
				<span class="btn btn-md btn-outline-secondary product-edit admin-action" data-url="/api/html/products/edit" data-product-id="<?= $product["id"] ?>">Edit</span>
				<span class="btn btn-md btn-outline-error product-remove admin-action" data-url="/api/html/products/remove" data-product-id="<?= $product["id"] ?>">Remove</span>
			</td>
		</tr>
<?php } ?>
	</tbody>
</table>
