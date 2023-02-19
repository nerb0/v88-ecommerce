<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="cart-container">
		<h2>Your Cart</h2>
		<div class="cart-list">
			<label for="cartSelectAll" class="cart-header">
				<input type="checkbox" id="cartSelectAll" class="btn cart-select-all" /> Select all
			</label>
			<form action="/products/validate_checkout">
				<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
				<div class="cart-item">
					<input type="checkbox" name="cart_item[]" value="1" class="cart-checkbox btn btn-outline-secondary"/><!--
					--><img src="" alt="" class="cart-image"><!--
					--><div class="cart-description">
						<p class="cart-name">Product Name</p>
						<p class="cart-price">$422</p>
						<div class="cart-form">
							<input class="btn btn-md btn-outline-primary cart-quantity" type="number" placeholder="Quantity" data-id="1" value="2" />
							<button type="button" class="btn btn-md btn-outline-error cart-remove">Remove</button>
						</div>
					</div>
					<div class="cart-total-price"><strong>Price</strong>: $424242</div>
				</div>
				<div class="cart-item">
					<input type="checkbox" name="cart_item[]" value="1" class="cart-checkbox btn btn-outline-secondary"/><!--
					--><img src="" alt="" class="cart-image"><!--
					--><div class="cart-description">
						<p class="cart-name">Product Name</p>
						<p class="cart-price">$422</p>
						<div class="cart-form">
							<input class="btn btn-md btn-outline-primary cart-quantity" type="number" placeholder="Quantity" data-id="1" value="2" />
							<button type="button" class="btn btn-md btn-outline-error cart-remove">Remove</button>
						</div>
					</div>
					<div class="cart-total-price"><strong>Price</strong>: $424242</div>
				</div>
				<div class="cart-item">
					<input type="checkbox" name="cart_item[]" value="1" class="cart-checkbox btn btn-outline-secondary"/><!--
					--><img src="" alt="" class="cart-image"><!--
					--><div class="cart-description">
						<p class="cart-name">Product Name</p>
						<p class="cart-price">$422</p>
						<div class="cart-form">
							<input class="btn btn-md btn-outline-primary cart-quantity" type="number" placeholder="Quantity" data-id="1" value="2" />
							<button type="button" class="btn btn-md btn-outline-error cart-remove">Remove</button>
						</div>
					</div>
					<div class="cart-total-price"><strong>Price</strong>: $424242</div>
				</div>
				<div class="light-effect-container mt-md">
					<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:600px;"></span>
					<input type="submit" value="Checkout" class="btn btn-lg btn-sharp btn-outline-secondary btn-span" />
				</div>
			</form>
		</div>
	</main>
