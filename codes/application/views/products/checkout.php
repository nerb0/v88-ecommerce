<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="checkout-container">
		<form action="/cart/process_checkout" method="post" id="checkoutForm">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
			<h2 class="mt-md">Your Orders:</h2>
			<div class="mt-md">
<?php		foreach($selected_items as $item) { ?>
				<div class="checkout-order-item">
					<input type="hidden" name="checkout_items[]" value="<?= $item["id"] ?>" />
					<img class="checkout-order-image" src="<?= $item["image"] ?>" /><!--
					--><div class="checkout-order-description">
						<p class="product-name"><?= $item["name"] ?></p>
						<p class="product-price">$ <?= number_format($item["price"], 2) ?></p>
						<p class="product-quantity">Quantity: <?= $item["quantity"] ?></p>
					</div>
					<div class="product-total-price">Total Price: $ <?= number_format($item["price"] * $item["quantity"], 2) ?></div>
				</div>
<?php		} ?>
			</div>

			<h2 class="mt-md">Saved Addresses:</h2>
			<div class="shipping-list" id="checkoutAddressList">
<?php		if (!empty($addresses)) {
				foreach($addresses as $address) { ?>
				<div class="shipping-card <?= $address["is_default"] ? "shipping-selected" : "" ?>" id="<?= $address["id"] ?>">
					<p class="shipping-name"><?= "{$address["first_name"]} {$address["last_name"]}" ?></p>
					<p class="shipping-address"><?= $address["address"] ?></p>
					<p class="shipping-email"><?= $address["email"] ?></p>
				</div>
<?php			}
			} else { ?>
				No Saved Address Found.
<?php 		} ?>
			</div>
			<div class="mt-md checkout-address">
				<div id="shippingAddressForm">
					<h2>Shipping Address:</h2>
					<div class="input-group">
						<label class="<?php if(!empty($default_address["first_name"])) echo "has-value" ?> input-default" style="--label: 'First Name'">
							<input
								type="text"
								name="shipping_first_name"
								value="<?= $default_address["first_name"] ?? "" ?>"
							/>
						</label><!--
						--><label class="<?php if(!empty($default_address["last_name"])) echo "has-value" ?> input input-default" style="--label: 'Last Name'">
							<input
								type="text"
								name="shipping_last_name"
								value="<?= $default_address["last_name"] ?? "" ?>"
							/>
						</label>
					</div>
					<label class="<?php if(!empty($default_address["email"])) echo "has-value" ?> input-default" style="--label: 'Email Address'">
						<input
							type="text"
							name="shipping_email"
							value="<?= $default_address["email"] ?? "" ?>"
						/>
					</label>
					<label class="<?php if(!empty($default_address["address"])) echo "has-value" ?> input-default" style="--label: 'Address 1'">
						<input
							type="text"
							name="shipping_address"
							value="<?= $default_address["address"] ?? "" ?>"
						/>
					</label>
					<label class="<?php if(!empty($default_address_two["address_two"])) echo "has-value" ?> input-default" style="--label: 'Address 2'">
						<input
							type="text"
							name="shipping_address_two"
							value="<?= $default_address["address_two"] ?? "" ?>"
						/>
					</label>
					<label class="<?php if(!empty($default_address["state"])) echo "has-value" ?> input-default" style="--label: 'State'">
						<input
							type="text"
							name="shipping_state"
							value="<?= $default_address["state"] ?? "" ?>"
						/>
					</label>
					<label class="<?php if(!empty($default_address["city"])) echo "has-value" ?> input-default" style="--label: 'City'">
						<input
							type="text"
							name="shipping_city"
							value="<?= $default_address["city"] ?? "" ?>"
						/>
					</label>
					<label class="<?php if(!empty($default_address["zipcode"])) echo "has-value" ?> input-default" style="--label: 'Zipcode'">
						<input
							type="text"
							name="shipping_zipcode"
							value="<?= $default_address["zipcode"] ?? "" ?>"
						/>
					</label>
				</div><!--
				--><div>
					<div class="relative">
						<h2 class="inline-block">Billing Address:</h2>
						<label for="setSameBillingBtn" class="billing-same-btn">
							<input type="checkbox" name="is_same_address" class="btn" id="setSameBillingBtn" /> Same as Shipping Address
						</label>
					</div>
					<div class="billing-address-form">
						<fieldset id="billingAddressForm">
							<div class="input-group">
								<label class="input-default" style="--label: 'First Name'">
									<input type="text" name="billing_first_name" data-field="first_name" />
								</label><!--
								--><label class="input input-default" style="--label: 'Last Name'">
									<input type="text" name="billing_last_name" data-field="last_name" />
								</label>
							</div>
							<label class="input-default" style="--label: 'Email Address'">
								<input type="text" name="billing_email" data-field="email" />
							</label>
							<label class="input-default" style="--label: 'Address 1'">
								<input type="text" name="billing_address" data-field="address" />
							</label>
							<label class="input-default" style="--label: 'Address 2'">
								<input type="text" name="billing_address_two" data-field="address_two" />
							</label>
							<label class="input-default" style="--label: 'State'">
								<input type="text" name="billing_state" data-field="state" />
							</label>
							<label class="input-default" style="--label: 'City'">
								<input type="text" name="billing_city" data-field="city" />
							</label>
							<label class="input-default" style="--label: 'Zipcode'">
								<input type="text" name="billing_zipcode" data-field="zipcode" />
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
				</div>
			</div>
			<div class="order-bill-detail">
				<div>
					<strong>Merchandise Subtotal</strong><!--
					--><span>$<?= $subtotal ?></span>
				</div>
				<div>
					<strong>Shipping Fee:</strong><!--
					--><span>$<?= $shipping_fee ?></span>
				</div>
				<div>
					<strong>Order Amount: </strong><!--
					--><span><strong>$<?= $order_total ?></strong></span>
				</div>
			</div>
			<div class="light-effect-container mt-md">
				<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:600px;"></span>
				<input type="submit" value="Checkout Order" class="btn btn-lg btn-sharp btn-outline-secondary btn-span" id="checkoutSubmitBtn" />
			</div>
		</form>
	</main>
