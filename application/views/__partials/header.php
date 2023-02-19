<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/style.js"></script>
	<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php if (!empty($links)) { ?>
	<nav>
		<div class="nav-logo">
			BrandLOGO
		</div><!--
		--><form class="nav-search" action="">
			<input type="text" name="search"/>
			<svg class="search-btn" id="searchBtn" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M14.5 14.5l-4-4m-4 2a6 6 0 110-12 6 6 0 010 12z"></path></svg>
		</form><!--
		--><div class="nav-links">
<?php		foreach($links as $title => $link) {
				$is_active = ($link == "#") ? "active" : "";
?>
				<a class="nav-link <?= $is_active ?>" href="<?= $link ?>"><?= $title ?></a>
<?php		} ?>
			<div class="nav-user dropdown" href="/users/account/">
				<strong>User Fullname</strong>
				<div class="dropdown-toggle">
					<svg class="dropdown-toggle-btn dropdown-toggle-closed" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 1.5l-7 12h14l-7-12z" stroke-linejoin="round"></path></svg>
				</div>
				<div class="dropdown-list transparent">
					<a class="dropdown-item-group" href="/users/profile">
						<svg class="dropdown-item-icon user-icon" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3 13v.5h1V13H3zm8 0v.5h1V13h-1zm-7 0v-.5H3v.5h1zm2.5-3h2V9h-2v1zm4.5 2.5v.5h1v-.5h-1zM8.5 10a2.5 2.5 0 012.5 2.5h1A3.5 3.5 0 008.5 9v1zM4 12.5A2.5 2.5 0 016.5 10V9A3.5 3.5 0 003 12.5h1zM7.5 3A2.5 2.5 0 005 5.5h1A1.5 1.5 0 017.5 4V3zM10 5.5A2.5 2.5 0 007.5 3v1A1.5 1.5 0 019 5.5h1zM7.5 8A2.5 2.5 0 0010 5.5H9A1.5 1.5 0 017.5 7v1zm0-1A1.5 1.5 0 016 5.5H5A2.5 2.5 0 007.5 8V7zm0 7A6.5 6.5 0 011 7.5H0A7.5 7.5 0 007.5 15v-1zM14 7.5A6.5 6.5 0 017.5 14v1A7.5 7.5 0 0015 7.5h-1zM7.5 1A6.5 6.5 0 0114 7.5h1A7.5 7.5 0 007.5 0v1zm0-1A7.5 7.5 0 000 7.5h1A6.5 6.5 0 017.5 1V0z"> </path>
						</svg><!--
						--><span class="dropdown-item-text">Account Settings</span>
					</a>
					<a class="dropdown-item-group" href="/users/logout">
						<svg class="dropdown-item-icon logout-icon" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="15" height="15">
							<path d="M13.5 7.5l-3 3.25m3-3.25l-3-3m3 3H4m4 6H1.5v-12H8"></path>
						</svg><!--
						--><span class="dropdown-item-text">Logout</span>
					</a>
				</div>
			</div>
			<a class="nav-cart" href="/products/cart">
				<svg class="cart-icon" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
					<path d="M.5.5l.6 2m0 0l2.4 8h11v-6a2 2 0 00-2-2H1.1zm11.4 12a1 1 0 110-2 1 1 0 010 2zm-8-1a1 1 0 112 0 1 1 0 01-2 0z"></path>
					<div class="cart-count">12</div>
				</svg>
			</a>
		</div>
	</nav>
<?php } ?>
