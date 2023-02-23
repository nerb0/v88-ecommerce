<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main>
		<header class="catalog-header">
			<h1> All Products </h1><!--
			--><form class="catalog-search-container" id="searchFilter">
				<div class="catalog-search-filter">
					<input type="text" name="search" placeholder="Search" class="catalog-search" id="searchProduct"/>
					<svg class="search-btn" id="searchBtn" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M14.5 14.5l-4-4m-4 2a6 6 0 110-12 6 6 0 010 12z"></path></svg>
				</div><!--
				--><div class="catalog-search-page" id="catalogPage">
					<input class="catalog-page-btn btn bg-transparent active" type="button" id="1" value="1"/>
					<input class="catalog-page-btn btn bg-transparent" type="button" id="2" value="2"/>
					<input class="catalog-page-btn btn bg-transparent" type="button" id="<?= $total_pages - 1 ?>" value=">>|"/>
				</div>
			</form>
		</header>
		<div class="catalog-container">
			<form class="catalog-filter" id="catalogFilter" action="/products/filter">
				Categories:
				<div class="category-filter">
<?php 			foreach ($categories as $cat) { ?>
					<label for="category<?= $cat["id"] ?>" class="input-checkbox">
						<input type="checkbox" name="category[]" id="category<?= $cat["id"] ?>" value="<?= $cat["id"] ?>"> <?= $cat["name"] ?>
					</label>
<?php			} ?>
					<div class="category-show-more" id="showMoreCategory">Show more...</div>
				</div>
				Price:
				<div class="ml input-group price-filter">
					<input type="number" step="0.01" name="min_price" placeholder="Min" /><!--
					--><input type="number" step="0.01" name="max_price" placeholder="Max" />
				</div>
			</form><!--
			--><div class="catalog-list" id="catalogList">
			</div>
		</div>
		<div id="catalogBottomPage" class="catalog-bottom-page">
		</div>
	</main>
