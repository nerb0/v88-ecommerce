<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="cart-container">
		<h2>Your Cart</h2>
		<div class="cart-list">
			<label for="cartSelectAll" class="cart-header">
				<input type="checkbox" id="cartSelectAll" class="btn cart-select-all" /> Select all
			</label>
			<form action="/cart/checkout" id="userCart">
				<div id="cartItemList">
				</div>
				<div class="text-right">
					<strong>Estimated Total Price:</strong> $
					<span id="cartTotalPrice">0</span>
				</div>
				<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
				<div class="light-effect-container mt-md">
					<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:600px;"></span>
					<input type="submit" value="Checkout" class="btn btn-lg btn-sharp btn-outline-secondary btn-span" />
				</div>
			</form>
		</div>
	</main>
