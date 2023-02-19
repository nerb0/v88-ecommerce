<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="center-container h-screen w-screen">
		<form action="/users/process_login/" method="post">
			<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
			<div class="user-form login-form mx-auto shadow-lg">
				<label class="input-default" style="--label: 'Email Address'">
					<input type="text" name="email" id="email"  />
				</label>
				<label class="input-default input-password" style="--label: 'Password'">
					<input type="text" name="password"  />
					<span id="passwordToggle"></span>
				</label>
				<div class="light-effect-container">
					<span id="lightEffect" class="light-effect light-hidden" style="--radius:600px;"></span>
					<input type="submit" value="Login" class="btn btn-xl btn-sharp btn-outline-primary btn-span" />
				</div>
				<div class="text-right">
					Do not have an account yet? <a href="/register">Sign Up!</a>
				</div>
			</div>
		</form>
	</main>
