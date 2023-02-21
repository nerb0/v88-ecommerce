<?php defined('BASEPATH') OR exit('No direct script access allowed');
	$total = 0;
	?>
		<form class="order-header" action="/orders/filter">
			<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
			<div class="admin-search">
				<div class="order-search">
					<input type="text" name="search" placeholder="Search" class="input-search btn-outline-secondary" />
					<svg class="search-btn" id="orderSearchBtn" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.5 14.5l-4-4m-4 2a6 6 0 110-12 6 6 0 010 12z"></path>
					</svg>
				</div>
			</div><!--
			--><div class="admin-misc">
				<select name="filter" id="filterOrder" class="btn btn-md btn-outline-secondary">
					<option value="0">All</option>
<?php			foreach ($statuses as $id => $status) {
					$is_selected =  (false) ? "selected" : ""; ?>
					<option <?= $is_selected ?> value="<?= $id + 1?>"><?= $status ?></option>
<?php			} ?>
				</select>
			</div>
		</form>
		<div id="orderList" class="order-list-container"></div>
		<div class="text-center">
<?php	for($i = 1; $i <= $total_pages; $i++) {
			$active = ($i == 1) ? "active" : "";
?>
			<span class="order-page-btn <?= $active ?>" id="<?= $i ?>"><?= $i ?></span>
<?php } ?>
		</div>
