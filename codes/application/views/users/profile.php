<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main>
		<div class="profile-form">
			<form action="/users/edit_profile/" method="post">
				<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
				<label class="input-default has-value" style="--label: 'First Name'">
					<input type="text" name="first_name" value="<?= $user["first_name"] ?>" />
				</label>
				<label class="input-default has-value" style="--label: 'Last Name'">
					<input type="text" name="last_name" value="<?= $user["last_name"] ?>" />
				</label>
				<label class="input-default has-value" style="--label: 'Email Address'">
					<input type="text" name="email" value="<?= $user["email"] ?>" />
				</label>
				<div class="change-password-toggle" id="changePasswordToggle">Change Password</div>
				<input type="hidden" value="0" name="change_password"/>
				<fieldset class="hidden" disabled="true">
					<label class="input-default input-password" style="--label: 'Old Password'">
						<input type="password" name="old_password"  />
						<span id="passwordToggle"></span>
					</label>
					<label class="input-default input-password" style="--label: 'New Password'">
						<input type="password" name="new_password"  />
						<span id="passwordToggle"></span>
					</label>
					<label class="input-default input-password" style="--label: 'Confirm Password'">
						<input type="password" name="confirm_password"  />
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
			<div class="shipping-list" id="shippingList">
<?php	if(!empty($addresses)) { 
			foreach($addresses as $address) { ?>
				<div class="shipping-card <?= $address["is_default"] ? "shipping-preferred" : "" ?>" id="<?= $address["id"] ?>">
					<p class="shipping-name"><?= "{$address["first_name"]} {$address["last_name"]}" ?></p>
					<p class="shipping-address"><?= $address["address"] ?></p>
					<p class="shipping-email"><?= $address["email"] ?></p>
				</div>
<?php		}
		}  else { ?>
				<span>No Addresses Found</span>
<?php	}?>
			</div>
			<h3>or Add a new Address: </h3>
			<form action="/addresses/create" method="post">
				<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
				<label  class="input-default <?php if(!empty($fields["first_name"])) echo "has-value" ?>" style="--label: 'First Name'">
					<input type="text" name="first_name" value="<?= $fields["first_name"] ?? "" ?>"/>
				</label>
				<label class="input-default <?php if(!empty($fields["last_name"])) echo "has-value" ?>" style="--label: 'Last Name'">
					<input type="text" name="last_name" value="<?= $fields["last_name"] ?? "" ?>" />
				</label>
				<label class="input-default <?php if(!empty($fields["address"])) echo "has-value" ?>" style="--label: 'Email Address'">
					<input type="text" name="email" value="<?= $fields["address"] ?? "" ?>" />
				</label>
				<label class="input-default <?php if(!empty($fields["address"])) echo "has-value" ?>" style="--label: 'Address 1'">
					<input type="text" name="address" value="<?= $fields["address"] ?? "" ?>" />
				</label>
				<label class="input-default <?php if(!empty($fields["address_two"])) echo "has-value" ?>" style="--label: 'Address 2'">
					<input type="text" name="address_two" value="<?= $fields["address_two"] ?? "" ?>" />
				</label>
				<label class="input-default <?php if(!empty($fields["state"])) echo "has-value" ?>" style="--label: 'State'">
					<input type="text" name="state" value="<?= $fields["state"] ?? "" ?>" />
				</label>
				<label class="input-default <?php if(!empty($fields["city"])) echo "has-value" ?>" style="--label: 'City'">
					<input type="text" name="city" value="<?= $fields["city"] ?? "" ?>" />
				</label>
				<label class="input-default <?php if(!empty($fields["zipcode"])) echo "has-value" ?>" style="--label: 'Zipcode'">
					<input type="text" name="zipcode" value="<?= $fields["zipcode"] ?? "" ?>" />
				</label>
				<div class="light-effect-container mt-md">
					<span id="lightEffect" class="light-effect light-hidden light-secondary" style="--radius:600px;"></span>
					<input type="submit" value="Save" class="btn btn-xl btn-sharp btn-outline-secondary btn-span" />
				</div>
			</form>
		</div>
	</main>
