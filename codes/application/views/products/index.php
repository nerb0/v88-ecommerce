<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="p-md">
		<div class="product-container">
			<div class="product-info-container">
				<div class="product-header">
					<h2 class="product-name"><?= $product["name"]?></h2>
					<p class="product-price">$<?= number_format($product["price"], 2) ?></p>
				</div>
				<div class="product-info">
					<div class="product-image-group">
						<img id="mainImagePreview" src="<?= $product["images"]["main"] ?>" alt="<?= $product["name"] ?>" class="product-image-main" />
						<div class="product-image-sub-container">
							<div class="product-image-sub" id="productImageSub"><!--
<?php						if (!empty($product["images"]["sub"])) { ?>
								--><div class="product-image-selected">
									<img src="<?= $product["images"]["main"] ?>" alt="<?= $product["name"] ?>" />
								</div><!--
<?php						} ?>
<?php						if (!empty($product["images"]["sub"])) {
								foreach ($product["images"]["sub"] as $index => $url) { ?>
								--><div>
									<img src="<?= $url ?>" alt="image<?= $index ?>" />
								</div><!--
<?php							}
							} ?>
							--></div>
						</div>
					</div><!--
					--><div class="product-description">
						<h3>About this Product:</h3>
						<div class="product-description-text">
							<?= $product["description"] ?>
						</div>
					</div>
<?php			if (!empty($user)) { ?>
					<form action="/cart/add" method="POST" class="product-buy-form" id="addToCartForm">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
						<input type="hidden" name="product_id" value="<?= $product["id"] ?>" />
						<input class="product-quantity btn-outline-secondary" type="number" name="quantity" placeholder="quantity" min="1" value="1"/>
						<div class="light-effect-container product-add-btn">
							<span id="lighteffect" class="light-effect light-hidden light-secondary" style="--radius:200px;"></span>
							<input type="submit" value="Add To Cart" class="btn btn-md btn-sharp btn-outline-secondary" />
						</div>
					</form>
<?php			} else { ?>
					<div class="product-buy-form">
						<div class="light-effect-container product-add-btn">
							<span id="lighteffect" class="light-effect light-hidden light-secondary" style="--radius:200px;"></span>
							<a href="/login" class="btn btn-md btn-sharp btn-outline-secondary">Login to Buy</a>
						</div>
					</div>
<?php			} ?>
				</div>
			</div>
			<div class="reviews-container">
<?php		if (!empty($user)) { ?>
				<h3>Create a Review</h3>
				<form action="/products/<?= $product["id"] ?>/review" class="review-form" method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<textarea name="message" placeholder="Enter message here..." class="btn-outline-secondary input-textarea"></textarea><!--
					--><input type="submit" value="Send Message" class="add-btn btn btn-md btn-sharp btn-outline-secondary btn-span" />
				</form>
<?php		} ?>
				<h2>Reviews</h2>
				<ul class="review-list">
<?php		if (!empty($reviews)) {
				foreach ($reviews as $review) { ?>
					<li class="relative mt-md">
						<span class="date"><?= date_format(date_create($review["created_at"]), "Y/m/d") ?></span>
						<div class="user"><?= $review["user_name"] ?> wrote: </div>
						<div class="message"><?= $review["message"] ?></div>
						<ul class="reply-list">
<?php				if (!empty($replies[$review["id"]])) {
						foreach ($replies[$review["id"]] as $reply) { ?>
							<li class="relative mt">
								<span class="date"><?= date_format(date_create($reply["created_at"]), "Y/m/d") ?></span>
								<div class="user"><?= $reply["user_name"] ?> wrote: </div>
								<div class="message"><?= $reply["message"] ?></div>
							</li>
<?php					}
					} ?>
<?php					if (!empty($user)) { ?>
							<form action="/reviews/<?= $review["id"] ?>/reply" method="post" class="reply-form mt">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
								<textarea name="message" placeholder="Enter message here..." class="btn-outline-secondary input-textarea"></textarea><!--
								--><input type="submit" value="Send Message" class="add-btn btn btn-md btn-sharp btn-outline-secondary btn-span" />
							</form>
<?php					} ?>
						</ul>
					</li>
<?php			}
			} ?>
				</ul>
			</div>
		</div><!--
		--><div class="product-sidebar">
			<h4>Similar Items</h4>
			<div class="similar-product-list" id="similarProductList">
				<?php if (empty($similar_products)) echo "No Similar Products Found." ?>
<?php		foreach ($similar_products as $product) { ?>
				<a class="similar-product-card" href="/products/show/<?= $product["id"] ?>">
					<img src="<?= $product["image"] ?>" alt="" class="product-image"><!--
					--><div class="similar-product-info">
						<p class="product-name"><?= $product["name"] ?></p>
						<p class="product-price">$ <?= number_format($product["price"], 2) ?></p>
						<p class="product-sold">Sold: <?= $product["sold"] ?? 0 ?></p>
					</div>
				</a>
<?php		} ?>
			</div>
		</div>
	</main>
