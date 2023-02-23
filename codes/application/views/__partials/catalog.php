<div class="product-list"><!--
<?php foreach ($products as $product) { ?>
	--><a href="/products/show/<?= $product["id"] ?>" class="product-card">
		<img src="<?= json_decode($product["images"], true)["main"] ?>" alt="" class="product-image" />
		<p class="product-name text-center"><?= $product["name"] ?></p>
		<p class="product-price">$<?= number_format($product["price"], 2) ?></p>
		<p class="product-sold">Sold: <?= $product["sold"] ?? 0 ?></p>
	</a><!--
<?php } ?>
--></div>
