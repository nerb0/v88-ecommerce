<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="edit-product">
	<svg id="closeEditBtn" class="modal-close edit-product-close" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
		<path d="M1.5 1.5l12 12m-12 0l12-12"></path>
	</svg>
	<h3 class="text-dark text-center">WARNING</h3>
	<form action="/cart/remove/<?= $id ?>" method="post" class="text-center" id="cartRemoveForm">
		<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
		<h2 class="text-dark mt-md"> Are you sure you want to remove Product `<?= $name ?>` from your cart?</h2>
		<input type="submit" class="btn btn-md btn-outline-primary-dark mt-md" value="Delete"/>
		<input type="button" class="btn btn-md btn-outline-error mt-md modal-close" value="Cancel"/>
	</form>
</div>
