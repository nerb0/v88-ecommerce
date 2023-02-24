<?php		foreach($addresses as $address) { ?>
<div class="shipping-card <?= $address["is_default"] ? "shipping-preferred" : "" ?>" id="<?= $address["id"] ?>">
	<p class="shipping-name"><?= "{$address["first_name"]} {$address["last_name"]}" ?></p>
	<p class="shipping-address"><?= $address["address"] ?></p>
	<p class="shipping-email"><?= $address["email"] ?></p>
</div>
<?php		} ?>
