<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="edit-product">
	<svg class="modal-close edit-product-close" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
		<path d="M1.5 1.5l12 12m-12 0l12-12"></path>
	</svg>
	<h3 class="text-dark">Edit Address:</h3>
	<form method="post" id="addressForm">
		<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
		<label  class="input-default input-dark has-value" style="--label: 'First Name'">
			<input type="text" name="first_name" value="<?= $first_name ?>"/>
		</label>
		<label class="input-default input-dark has-value" style="--label: 'Last Name'">
			<input type="text" name="last_name" value="<?= $last_name ?>" />
		</label>
		<label class="input-default input-dark has-value" style="--label: 'Email Address'">
			<input type="text" name="email" value="<?= $email ?>" />
		</label>
		<label class="input-default input-dark has-value" style="--label: 'Address 1'">
			<input type="text" name="address" value="<?= $address ?>" />
		</label>
		<label class="input-default input-dark <?php if(!empty($address_two)) echo "has-value" ?>" style="--label: 'Address 2'">
			<input type="text" name="address_two" value="<?= $address_two ?? "" ?>" />
		</label>
			<label class="input-default input-dark has-value" style="--label: 'State'">
			<input type="text" name="state" value="<?= $state ?>" />
		</label>
		<label class="input-default input-dark has-value" style="--label: 'City'">
			<input type="text" name="city" value="<?= $city ?>" />
		</label>
		<label class="input-default input-dark has-value" style="--label: 'Zipcode'">
			<input type="text" name="zipcode" value="<?= $zipcode ?>" />
		</label>
		<div class="modal-actions">
			<div id="addressDefault">
<?php		if(!$is_default) { ?>
				<input type="button" class="btn btn-md btn-outline-secondary-dark mt-md address-action-btn" data-action="setDefault" data-url="/users/address/default/<?= $id ?>" id="<?= $id ?>" value="Set as Default Address"/>
<?php		}	else { ?>
				<span class="text-dark">Default Address</span>
<?php		} ?>
			</div><!--
			--><div class="text-right">
				<input type="button" class="btn btn-md btn-outline-primary-dark mt-md address-action-btn" data-action="update" data-url="/users/address/update/<?= $id ?>" id="<?= $id ?>" value="Update"/>
				<input type="button" class="btn btn-md btn-outline-error mt-md modal-close" value="Cancel"/>
			</div>
		</div>
	</form>
</div>
