<?php foreach ($items as $item) { ?>
<div class="cart-item">
	<input type="checkbox" name="cart_items[]" class="cart-checkbox btn btn-outline-secondary" value="<?= $item["id"] ?>"/><!--
	--><img alt="" class="cart-image" src="<?= $item["image"] ?>" /><!--
	--><div class="cart-description">
		<p class="cart-name"><?= $item["name"] ?></p>
		<p class="cart-price">$<?= number_format($item["price"], 2) ?></p>
		<div class="cart-form">
			<input class="btn btn-md btn-outline-primary cart-quantity" type="number" placeholder="Quantity" min="1" max="<?= $item["stock"] ?>" id="<?= $item["id"] ?>" value="<?= $item["quantity"] ?>" />
			<button type="button" class="btn btn-md btn-outline-error cart-remove" id="<?= $item["id"] ?>">Remove</button>
		</div>
	</div>
	<div class="cart-total-price">
		<strong>Price</strong>: $
		<span id="<?= $item["id"] ?>" class="cart-item-total-price"><?= number_format($item["quantity"] * $item["price"], 2) ?></span>
	</div>
</div>
<?php }  ?>
