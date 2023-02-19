<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main>
		<div class="profile-form">
			<form action="/users/edit_profile/" method="post">
				<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
				<label class="input-default" style="--label: 'First Name'">
					<input type="text" name="first_name" />
				</label>
				<label class="input-default" style="--label: 'Last Name'">
					<input type="text" name="last_name" />
				</label>
				<label class="input-default" style="--label: 'Email Address'">
					<input type="text" name="email" />
				</label>
				<div class="change-password-toggle" id="changePasswordToggle">Change Password</div>
				<fieldset class="hidden" disabled="true">
					<input type="hidden" value="0" name="change_password"/>
					<label class="input-default input-password" style="--label: 'Old Password'">
						<input type="text" name="old_password"  />
						<span id="passwordToggle"></span>
					</label>
					<label class="input-default input-password" style="--label: 'New Password'">
						<input type="text" name="new_password"  />
						<span id="passwordToggle"></span>
					</label>
					<label class="input-default input-password" style="--label: 'Confirm Password'">
						<input type="text" name="confirm_password"  />
						<span id="passwordToggle"></span>
					</label>
				</fieldset>
				<div class="light-effect-container mt-md">
					<span id="lightEffect" class="light-effect light-hidden" style="--radius:600px;"></span>
					<input type="submit" value="Save" class="btn btn-xl btn-sharp btn-outline-primary btn-span" />
				</div>
			</form>
		</div><!--
		--><div class="shipping-form">
			<h3>Select a preferred Address: </h3>
			<div class="shipping-list">
				<div class="shipping-card shipping-preferred">
					<p class="shipping-name">Shipping Full Name</p>
					<p class="shipping-address">Shipping Full Address</p>
					<p class="shipping-email">Shipping Email</p>
				</div><!--
				--><div class="shipping-card">
					<p class="shipping-name">Shipping Full Name</p>
					<p class="shipping-address">Shipping Full Address</p>
					<p class="shipping-email">Shipping Email</p>
				</div>
				<div class="shipping-card">
					<p class="shipping-name">Shipping Full Name</p>
					<p class="shipping-address">Shipping Full Address</p>
					<p class="shipping-email">Shipping Email</p>
				</div><!--
				--><div class="shipping-card">
					<p class="shipping-name">Shipping Full Name</p>
					<p class="shipping-address">Shipping Full Address</p>
					<p class="shipping-email">Shipping Email</p>
				</div>
			</div>
			<h3>or Add a new Address: </h3>
			<form action="/users/add_address" method="post">
				<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
				<label class="input-default" style="--label: 'First Name'">
					<input type="text" name="first_name" />
				</label>
				<label class="input-default" style="--label: 'Last Name'">
					<input type="text" name="last_name" />
				</label>
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
				<div class="light-effect-container mt-md">
					<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:600px;"></span>
					<input type="submit" value="Save" class="btn btn-xl btn-sharp btn-outline-secondary btn-span" />
				</div>
			</form>
		</div>
	</main>
