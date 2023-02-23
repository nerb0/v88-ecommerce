<?php defined('BASEPATH') OR exit('No direct script access allowed');
	?>
		<form class="admin-header" data-field="products">
			<div class="admin-search">
				<div class="order-search">
					<input type="text" name="search" placeholder="Search" class="input-search btn-outline-secondary" />
					<svg class="search-btn" id="orderSearchBtn" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.5 14.5l-4-4m-4 2a6 6 0 110-12 6 6 0 010 12z"></path>
					</svg>
				</div>
			</div><!--
			--><div class="admin-misc">
				<span id="addProductBtn" class="btn btn-md btn-outline-secondary admin-action" data-url="/api/html/products/add">
					Add a New Product
				</span>
			</div>
		</form>
		<div id="adminList" class="admin-list-container">
		</div>
		<div class="text-center" id="adminPagination">
		</div>
