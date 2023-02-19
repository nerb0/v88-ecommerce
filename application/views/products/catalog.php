<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main>
		<header class="catalog-header">
			<h1> All Products </h1><!--
			--><form class="catalog-search-container" action="/products/filter">
				<div class="catalog-search-filter">
					<input type="text" name="search" placeholder="Search" class="catalog-search" />
					<svg class="search-btn" id="searchBtn" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M14.5 14.5l-4-4m-4 2a6 6 0 110-12 6 6 0 010 12z"></path></svg>
				</div><!--
				--><div class="catalog-search-page">
					<input class="btn bg-transparent" type="button" name="first" value="|<<"/>
					<input class="btn bg-transparent" type="button" name="2" value="2"/>
					<input class="btn bg-transparent active" type="button" name="3" value="3"/>
					<input class="btn bg-transparent" type="button" name="4" value="4"/>
					<input class="btn bg-transparent" type="button" name="last" value=">>|"/>
				</div>
			</form>
		</header>
		<div class="catalog-container h-screen w-screen">
			<form class="catalog-filter" action="/products/filter">
				Categories:
				<div class="category-filter">
					<label for="category1" class="input-checkbox">
						<input type="checkbox" name="category[]" id="category1"> Category1
					</label>
					<label for="category2" class="input-checkbox">
						<input type="checkbox" name="category[]" id="category2"> Category2
					</label>
					<label for="category3" class="input-checkbox">
						<input type="checkbox" name="category[]" id="category3"> Category3
					</label>
					<label for="category4" class="input-checkbox">
						<input type="checkbox" name="category[]" id="category4"> Category4
					</label>
					<div class="category-show-more" id="showMoreCategory">Show more...</div>
				</div>
				Price:
				<div class="ml input-group price-filter">
					<input type="number" step="0.1" name="min_price" placeholder="Min" />
					<input type="number" step="0.1" name="max_price" placeholder="Max" />
				</div>
				<input type="submit" value="Filter" class="btn btn-md btn-sharp btn-outline-secondary " />
			</form><!--
			--><div class="product-list">
				<a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a><!--
				--><a href="/products/show/1" class="product-card">
					<img src="" alt="" class="product-image" />
					<p class="product-name text-center">Product Name</p>
					<p class="product-price">$242442</p>
					<p class="product-sold">Sold: 4242</p>
				</a>
			</div>
		</div>
	</main>
