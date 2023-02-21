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
						<img src="<?= $product["images"]["main"] ?>" alt="<?= $product["name"] ?>" class="product-image-main" />
						<div class="product-image-sub-container">
							<div class="product-image-sub" id="productImageSub"><!--
<?php						if (!empty($product["images"]["sub"])) {
								foreach ($product["images"]["sub"] as $index => $url) { ?>
								--><img src="<?= $url ?>" alt="image<?= $index ?>" /><!--
<?php							}
							} ?>
							--></div>
						</div>
					</div><!--
					--><div class="product-description">
					<h3>About this Product:</h3>
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras pulvinar tellus vitae erat pharetra malesuada. Morbi ante risus, consectetur id mauris quis, laoreet rhoncus leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras eget dapibus odio. Proin rutrum pharetra egestas. Cras in massa eget augue fringilla tempor. Etiam vitae ipsum finibus, lobortis massa quis, mattis sem. Donec ultricies volutpat finibus. Integer cursus leo volutpat lacinia maximus. Etiam hendrerit elit nisl, et egestas lorem varius a. Integer in ornare eros. Vivamus non elit non magna aliquet laoreet. Curabitur vestibulum eleifend rutrum. Mauris tristique, enim nec consectetur rhoncus, orci erat aliquet nibh, molestie mollis arcu quam id libero. Fusce ac condimentum urna. Mauris convallis laoreet mi, eu consequat est ullamcorper at. Donec sed magna sodales purus bibendum cursus a eget enim. Proin non consectetur ante. In et sem vel lectus scelerisque mollis.
					</div>
					<form action="/products/add_to_cart/<?= $product["id"] ?>" method="POST" class="product-buy-form">
						<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
						<input class="product-quantity btn-outline-secondary" type="number" name="quantity" placeholder="Quantity" min="1" value="1"/>
						<div class="light-effect-container product-add-btn">
							<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:200px;"></span>
							<input type="submit" value="Add to Cart" class="btn btn-md btn-sharp btn-outline-secondary" />
						</div>
					</form>
				</div>
			</div>
			<div class="reviews-container">
				<h3>Create a Review</h3>
				<form action="/products/1/review" class="review-form" method="post">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
					<textarea name="message" placeholder="Enter message here..." class="btn-outline-secondary input-textarea"></textarea><!--
					--><input type="submit" value="Send Message" class="add-btn btn btn-md btn-sharp btn-outline-secondary btn-span" />
				</form>
				<h2>Reviews</h2>
				<ul class="review-list">
					<li class="relative">
						<span class="date">YYYY/mm/dd</span>
						<div class="user">User full name wrote: </div>
						<div class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras pulvinar tellus vitae erat pharetra malesuada. Morbi ante risus, consectetur id mauris quis, laoreet rhoncus leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras eget dapibus odio. Proin rutrum pharetra egestas. Cras in massa eget augue fringilla tempor.</div>
						<ul class="reply-list">
							<li class="relative">
								<span class="date">YYYY/mm/dd</span>
								<div class="user">User full name wrote: </div>
								<div class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras pulvinar tellus vitae erat pharetra malesuada. Morbi ante risus, consectetur id mauris quis, laoreet rhoncus leo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras eget dapibus odio. Proin rutrum pharetra egestas. Cras in massa eget augue fringilla tempor.</div>
							</li>
							<form action="/review/1/reply" method="post" class="reply-form">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
								<textarea name="message" placeholder="Enter message here..." class="btn-outline-secondary input-textarea"></textarea><!--
								--><input type="submit" value="Send Message" class="add-btn btn btn-md btn-sharp btn-outline-secondary btn-span" />
							</form>
						</ul>
					</li>
				</ul>
			</div>
		</div><!--
		--><div class="product-sidebar">
			<h4>Similar Items</h4>
			<div class="similar-product-list">
				<a class="similar-product-card" href="/products/show/1">
					<img src="" alt="" class="product-image"><!--
					--><div class="similar-product-info">
						<p class="product-name">Product Name</p>
						<p class="product-price">$424242</p>
						<p class="product-sold">Sold: 3232</p>
					</div>
				</a>
				<a class="similar-product-card" href="/products/show/1">
					<img src="" alt="" class="product-image"><!--
					--><div class="similar-product-info">
						<p class="product-name">Product Name</p>
						<p class="product-price">$424242</p>
						<p class="product-sold">Sold: 3232</p>
					</div>
				</a>
				<a class="similar-product-card" href="/products/show/1">
					<img src="" alt="" class="product-image"><!--
					--><div class="similar-product-info">
						<p class="product-name">Product Name</p>
						<p class="product-price">$424242</p>
						<p class="product-sold">Sold: 3232</p>
					</div>
				</a>
				<a class="similar-product-card" href="/products/show/1">
					<img src="" alt="" class="product-image"><!--
					--><div class="similar-product-info">
						<p class="product-name">Product Name</p>
						<p class="product-price">$424242</p>
						<p class="product-sold">Sold: 3232</p>
					</div>
				</a>
				<a class="similar-product-card" href="/products/show/1">
					<img src="" alt="" class="product-image"><!--
					--><div class="similar-product-info">
						<p class="product-name">Product Name</p>
						<p class="product-price">$424242</p>
						<p class="product-sold">Sold: 3232</p>
					</div>
				</a>
			</div>
		</div>
	</main>
