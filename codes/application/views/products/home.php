<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="featured-banner">
		<div class="featured-slide-container">
			<div class="featured-slide" id="featuredSlide">
				<div class="featured-item-list"><!--
<?php			for ($i = 0; $i < 3; $i++) { ?>
					--><div class="featured-item">
						<img src="<?= $banner_products[$i]["image"] ?>" alt="" class="featured-item-image"/>
						<div class="featured-item-name"><?= $banner_products[$i]["name"] ?></div>
					</div><!--
<?php			} ?>
				--></div><!--
				--><div class="featured-item-list"><!--
<?php			for ($i = 3; $i < 6; $i++) { ?>
					--><div class="featured-item">
						<img src="<?= $banner_products[$i]["image"] ?>" alt="" class="featured-item-image"/>
						<div class="featured-item-name"><?= $banner_products[$i]["name"] ?></div>
					</div><!--
<?php			} ?>
				--></div><!--
				--><div class="featured-item-list"><!--
<?php			for ($i = 6; $i < 9; $i++) { ?>
					--><div class="featured-item">
						<img src="<?= $banner_products[$i]["image"] ?>" alt="" class="featured-item-image"/>
						<div class="featured-item-name"><?= $banner_products[$i]["name"] ?></div>
					</div><!--
<?php			} ?>
				--></div>
			</div>
		</div>
		<div class="featured-navigation" id="featuredNav">
			<span class="featured-btn selected" data-index="0">
				<div></div>
			</span>
			<span class="featured-btn" data-index="1">
				<div></div>
			</span>
			<span class="featured-btn" data-index="2">
				<div></div>
			</span>
		</div>
	</main>
	<div class="categories-container">
		<h1 class="text-center">Shop by Category</h1>
		<div class="category-list"><!--
<?php	foreach ($categories as $category) { ?>
			--><a href="/products/catalog?category=<?= $category["id"] ?>" class="category-card">
				<img src="" alt="" class="category-image" />
				<p class="text-center"><?= $category["name"] ?></p>
			</a><!--
<?php	} ?>
		--></div>
	</div>
	<div class="featured-products">
		<h1 class="text-center">Featured Products</h1>
		<div class="product-list"><!--
<?php	foreach ($featured_products as $product) { ?>
			--><a href="/products/show/<?= $product["id"] ?>" class="product-card">
				<img src="<?= $product["image"] ?>" alt="" class="product-image" />
				<p class="product-name text-center"><?= $product["name"] ?></p>
				<p class="product-price">$ <?= number_format($product["price"], 2) ?></p>
				<p class="product-sold">Sold: <?= $product["sold"] ?></p>
			</a><!--
<?php	} ?>
		--></div>
	</div>
