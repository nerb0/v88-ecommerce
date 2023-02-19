<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
				<span class="btn btn-md btn-outline-secondary" id="addNewProduct">Add a New Product</span>
			</div>
		</form>
		<table class="admin-list">
			<thead>
				<tr>
					<th>Picture</th>
					<th class="id">ID</th>
					<th>Name</th>
					<th>Inventory Count</th>
					<th>Product Sold</th>
					<th>Price</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center"><img src="" alt="" class="product-image"/></td>
					<td class="text-center">1</td>
					<td>Bob</td>
					<td>16/12/2222</td>
					<td>123 something streeet something address</td>
					<td>$125.23</td>
					<td>
						<span class="btn btn-md btn-outline-secondary product-edit">Edit</span>
						<span class="btn btn-md btn-outline-error product-remove">Remove</span>
					</td>
				</tr>
				<tr>
					<td class="text-center"><img src="" alt="" class="product-image"/></td>
					<td class="text-center">1</td>
					<td>Bob</td>
					<td>16/12/2222</td>
					<td>123 something streeet something address</td>
					<td>$125.23</td>
					<td>
						<span class="btn btn-md btn-outline-secondary product-edit">Edit</span>
						<span class="btn btn-md btn-outline-error product-remove">Remove</span>
					</td>
				</tr>
				<tr>
					<td class="text-center"><img src="" alt="" class="product-image"/></td>
					<td class="text-center">1</td>
					<td>Bob</td>
					<td>16/12/2222</td>
					<td>123 something streeet something address</td>
					<td>$125.23</td>
					<td>
						<span class="btn btn-md btn-outline-secondary product-edit">Edit</span>
						<span class="btn btn-md btn-outline-error product-remove">Remove</span>
					</td>
				</tr>
			</tbody>
		</table>
