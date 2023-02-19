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
		<div class="admin-nav-logo">
			Dashboard
		</div>
		<div class="admin-nav-links">
<?php	foreach($links as $title => $link) {
			$is_active = ($link == "#") ? "active" : "";
?>
			<a class="nav-link <?= $is_active ?>" href="<?= $link ?>"><?= $title ?></a>
<?php	} ?>
		</div>
	</nav>
<?php } ?>
