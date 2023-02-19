<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="checkout-container">
		<form action="/products/process_checkout">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
			<h2>Shipping Address:</h2>
			<div class="checkout-shipping-address-container">
				<p class="checkout-shipping-name">Shipping Full Name</p>
				<p class="checkout-shipping-address">Shipping Full Address</p>
				<p class="checkout-shipping-email">Shipping Email</p>
				<div id="selectCheckoutShippingAddress" class="select-shipping-address">
					<svg class="select-shipping-address-btn" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15">
						<path d="M5 14l7-6.5L5 1" stroke-linecap="square"></path>
					</svg>
				</div>
			</div>
			<h2 class="mt-md">Your Orders:</h2>
			<div class="checkout-order-item mt">
				<input type="hidden" name="product_id" value="1" />
				<img class="checkout-order-image"/><!--
				--><div class="checkout-order-description">
					<p class="product-name">Product Name</p>
					<p class="product-price">$342</p>
					<p class="product-quantity">Quantity: 32</p>
				</div>
				<div class="product-total-price">Total Price: $3424242</div>
			</div>
			<div class="checkout-order-item">
				<input type="hidden" name="product_id" value="1" />
				<img class="checkout-order-image"/><!--
				--><div class="checkout-order-description">
					<p class="product-name">Product Name</p>
					<p class="product-price">$342</p>
					<p class="product-quantity">Quantity: 32</p>
				</div>
				<div class="product-total-price">Total Price: $3424242</div>
			</div>
			<div class="checkout-order-item">
				<input type="hidden" name="product_id" value="1" />
				<img class="checkout-order-image"/><!--
				--><div class="checkout-order-description">
					<p class="product-name">Product Name</p>
					<p class="product-price">$342</p>
					<p class="product-quantity">Quantity: 32</p>
				</div>
				<div class="product-total-price">Total Price: $3424242</div>
			</div>

			<div class="mt-md relative">
				<h2 class="inline-block">Billing Address:</h2>
				<label for="setSameBillingBtn" class="billing-same-btn">
					<input type="checkbox" name="is_same_address" class="btn" id="setSameBillingBtn" /> Same as Shipping Address
				</label>
			</div>
			<div class="billing-address-form">
				<fieldset id="billingAddressForm">
					<div class="input-group">
						<label class="input-default" style="--label: 'First Name'">
							<input type="text" name="first_name" />
						</label><!--
						--><label class="input input-default" style="--label: 'Last Name'">
							<input type="text" name="last_name" />
						</label>
					</div>
					<label class="input-default" style="--label: 'Email Address'">
						<input type="text" name="email" />
					</label>
					<label class="input-default" style="--label: 'Address 1'">
						<input type="text" name="address" />
					</label>
					<label class="input-default" style="--label: 'Address 2'">
						<input type="text" name="address_two" />
					</label>
					<label class="input-default" style="--label: 'State'">
						<input type="text" name="state" />
					</label>
					<label class="input-default" style="--label: 'City'">
						<input type="text" name="city" />
					</label>
					<label class="input-default" style="--label: 'Zipcode'">
						<input type="text" name="zipcode" />
					</label>
				</fieldset>
				<div class="billing-card-info">
					<label class="input-default card-number" style="--label: 'Card Number'">
						<input type="text" name="card_number" />
					</label><!--
					--><label class="input-default card-cvc" style="--label: 'CVC'">
						<input type="text" name="card_cvc" max="3" />
					</label><!--
					--><label class="input-default card-expiry" style="--label: 'Expiry'">
						<input type="text" name="card_expiry" max="7" />
					</label>
				</div>
			</div>
			<div class="order-bill-detail">
				<div>
					<strong>Merchandise Subtotal</strong><!--
					--><span>$4040</span>
				</div>
				<div>
					<strong>Shipping Fee:</strong><!--
					--><span>$4.99</span>
				</div>
				<div>
					<strong>Order Amount:</strong><!--
					--><span><strong>$4044.99</strong></span>
				</div>
			</div>
			<div class="light-effect-container mt-md">
				<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:600px;"></span>
				<input type="submit" value="Checkout Order" class="btn btn-lg btn-sharp btn-outline-secondary btn-span" />
			</div>
		</form>
	</main>
