<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/assets/css/jquery-ui.css" />
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/jquery-ui.min.js"></script>
	<script src="/assets/js/script.js"></script>
	<link href="/assets/css/style.css" rel="stylesheet">
	<link href="/assets/css/util.css" rel="stylesheet">
</head>
<body>
<?php if (!empty($message)) { ?>
	<div class="notif-message <?= $message_type ?>">
		<?= $message ?>
	</div>
<?php } ?>
<?php if (!empty($links)) { ?>
	<nav class="admin-nav">
		<a class="nav-logo" href="/admin/orders">
			SLAP<strong>SHTICK</strong>
		</a><!--
		--><div class="nav-links">
<?php	foreach($links as $title => $link) {
			$is_active = ($link == "#") ? "active" : "";
?>
			<a class="nav-link <?= $is_active ?>" href="<?= $link ?>"><?= $title ?></a>
<?php	} ?>
		</div>
		<a href="/users/logout" class="admin-logout">Logout</a>
	</nav><!--
<?php } ?>
	--><main class="admin-container">
