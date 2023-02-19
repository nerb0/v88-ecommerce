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
				<select name="filter" id="filterOrder" class="btn btn-md btn-outline-secondary">
					<option value="0">Show All</option>
					<option value="1">To Process</option>
					<option value="2">To Ship</option>
					<option value="3">Shipping</option>
					<option value="4">Cancelled</option>
					<option value="5">Delivered</option>
				</select>
			</div>
		</form>
		<table class="admin-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Date</th>
					<th>Billing Address</th>
					<th>Total Price</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="id"><a href="/orders/show/1">1</a></td>
					<td>Bob</td>
					<td>16/12/2222</td>
					<td>123 something streeet something address</td>
					<td>$125.23</td>
					<td>
						<form action="/orders/edit/1">
							<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
							<select name="status" class="order-edit-status btn btn-md btn-outline-secondary">
								<option value="1">To Process</option>
								<option value="2">To Ship</option>
								<option value="3">Shipping</option>
								<option value="4">Cancelled</option>
								<option value="5">Delivered</option>
							</select>
						</form>
					</td>
				</tr>
				<tr>
					<td class="id"><a href="/orders/show/1">1</a></td>
					<td>Bob</td>
					<td>16/12/2222</td>
					<td>123 something streeet something address</td>
					<td>$125.23</td>
					<td>
						<form action="/orders/edit/1">
							<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
							<select name="status" class="order-edit-status btn btn-md btn-outline-secondary">
								<option value="1">To Process</option>
								<option value="2">To Ship</option>
								<option value="3">Shipping</option>
								<option value="4">Cancelled</option>
								<option value="5">Delivered</option>
							</select>
						</form>
					</td>
				</tr>
				<tr>
					<td class="id"><a href="/orders/show/1">1</a></td>
					<td>Bob</td>
					<td>16/12/2222</td>
					<td>123 something streeet something address</td>
					<td>$125.23</td>
					<td>
						<form action="/orders/edit/1">
							<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
							<select name="status" class="order-edit-status btn btn-md btn-outline-secondary">
								<option value="1">To Process</option>
								<option value="2">To Ship</option>
								<option value="3">Shipping</option>
								<option value="4">Cancelled</option>
								<option value="5">Delivered</option>
							</select>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
