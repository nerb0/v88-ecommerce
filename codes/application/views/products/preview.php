<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/script.js"></script>
	<script src="/assets/js/product.js"></script>
	<link href="/assets/css/style.css" rel="stylesheet">
	<link href="/assets/css/util.css" rel="stylesheet">
	<link href="/assets/css/product.css" rel="stylesheet">
</link>
<body>
	<nav class="nav">
		<a class="nav-logo" href="/home">
			SLAP<strong>SHTICK</strong>
		</a><!--
		--><form class="nav-search" action="">
			<input type="text" name="search"/>
			<svg class="search-btn" id="searchBtn" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M14.5 14.5l-4-4m-4 2a6 6 0 110-12 6 6 0 010 12z"></path></svg>
		</form><!--
		--><div class="nav-links">
			<a class="nav-link" href="#">Home</a>
			<a class="nav-link" href="#">Catalog</a>
			<div class="nav-user dropdown">
				<strong>User's Full Name</strong>
				<div class="dropdown-toggle">
					<svg class="dropdown-toggle-btn dropdown-toggle-closed" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.5 1.5l-7 12h14l-7-12z" stroke-linejoin="round"></path>
					</svg>
				</div>
				<div class="dropdown-list transparent">
					<a class="dropdown-item-group" href="#">
						<svg class="dropdown-item-icon user-icon" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3 13v.5h1V13H3zm8 0v.5h1V13h-1zm-7 0v-.5H3v.5h1zm2.5-3h2V9h-2v1zm4.5 2.5v.5h1v-.5h-1zM8.5 10a2.5 2.5 0 012.5 2.5h1A3.5 3.5 0 008.5 9v1zM4 12.5A2.5 2.5 0 016.5 10V9A3.5 3.5 0 003 12.5h1zM7.5 3A2.5 2.5 0 005 5.5h1A1.5 1.5 0 017.5 4V3zM10 5.5A2.5 2.5 0 007.5 3v1A1.5 1.5 0 019 5.5h1zM7.5 8A2.5 2.5 0 0010 5.5H9A1.5 1.5 0 017.5 7v1zm0-1A1.5 1.5 0 016 5.5H5A2.5 2.5 0 007.5 8V7zm0 7A6.5 6.5 0 011 7.5H0A7.5 7.5 0 007.5 15v-1zM14 7.5A6.5 6.5 0 017.5 14v1A7.5 7.5 0 0015 7.5h-1zM7.5 1A6.5 6.5 0 0114 7.5h1A7.5 7.5 0 007.5 0v1zm0-1A7.5 7.5 0 000 7.5h1A6.5 6.5 0 017.5 1V0z"> </path>
						</svg><!--
						--><span class="dropdown-item-text">Account Settings</span>
					</a>
					<a class="dropdown-item-group" href="#">
						<svg class="dropdown-item-icon logout-icon" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15">
							<path d="M13.5 7.5l-3 3.25m3-3.25l-3-3m3 3H4m4 6H1.5v-12H8"></path>
						</svg><!--
						--><span class="dropdown-item-text">Logout</span>
					</a>
				</div>
			</div>
			<a class="nav-cart" href="#">
				<svg class="cart-icon" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
					<path d="M.5.5l.6 2m0 0l2.4 8h11v-6a2 2 0 00-2-2H1.1zm11.4 12a1 1 0 110-2 1 1 0 010 2zm-8-1a1 1 0 112 0 1 1 0 01-2 0z"></path>
					<div class="cart-count" id="cartCount">0</div>
				</svg>
			</a>
		</div>
	</nav>
	<div class="modal-container hidden" id="modalContainer">
		<div id="modal" class="modal">
		</div>
	</div>
	<div id="messageBox" class="hidden">
	</div>
	<main class="p-md">
		<div class="product-container">
			<div class="product-info-container">
				<div class="product-header">
					<h2 class="product-name"><?= $name ?? "" ?></h2>
					<p class="product-price">$<?= number_format((is_int($price) ? $price : 0), 2) ?></p>
				</div>
				<div class="product-info">
					<div class="product-image-group">
						<img src="<?= $main_image ?? "" ?>" alt="" class="product-image-main" />
						<div class="product-image-sub-container">
							<div class="product-image-sub" id="productImageSub"><!--
<?php						if (!empty($images)) {
								foreach ($images as $index => $url) {
									if($url != $main_image) { ?> 
								--><img src="<?= $url ?>" alt="image<?= $index ?>" /><!--
<?php								}
								}
							} ?>
							--></div>
						</div>
					</div><!--
					--><div class="product-description">
						<h3>About this Product:</h3>
						<?= $description ?? "" ?>
					</div>
					<div class="product-buy-form">
						<input class="product-quantity btn-outline-secondary" type="number" name="quantity" placeholder="Quantity" min="1" value="1"/>
						<div class="light-effect-container product-add-btn">
							<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:200px;"></span>
							<input type="submit" value="Add to Cart" class="btn btn-md btn-sharp btn-outline-secondary" />
						</div>
					</div>
				</div>
			</div>
			<div class="reviews-container">
				<h3>Create a Review</h3>
				<div class="review-form">
					<textarea name="message" placeholder="Enter message here..." class="btn-outline-secondary input-textarea"></textarea><!--
					--><input type="submit" value="Send Message" class="add-btn btn btn-md btn-sharp btn-outline-secondary btn-span" />
				</div>
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
							<div action="#" class="reply-form">
								<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
								<textarea name="message" placeholder="Enter message here..." class="btn-outline-secondary input-textarea"></textarea><!--
								--><input type="submit" value="Send Message" class="add-btn btn btn-md btn-sharp btn-outline-secondary btn-span" />
							</div>
						</ul>
					</li>
				</ul>
			</div>
		</div><!--
		--><div class="product-sidebar">
			<h4>Similar Items</h4>
			<div class="similar-product-list">
				<a class="similar-product-card" href="#">
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
	<footer>
	</footer>
</body>

</html>
