<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<main class="center-container h-screen w-screen">
		<form action="/users/process_login/" method="post">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
			<div class="user-form register-form mx-auto shadow-lg">
				<div class="input-group">
					<label class="input-default" style="--label: 'First Name'">
						<input type="text" name="first_name" />
					</label><!--
					--><label class="input input-default" style="--label: 'Last Name'">
						<input type="text" name="last_name" />
					</label>
				</div>
				<label class="input-default" style="--label: 'Email Address'">
					<input type="text" name="email" />
				</label>
				<label class="input-default input-password" style="--label: 'Password'">
					<input type="password" name="password" />
					<span id="passwordToggle"></span>
				</label>
				<label class="input-default input-password" style="--label: 'Confirm Password'">
					<input type="password" name="confirm_password" />
					<span id="passwordToggle"></span>
				</label>
				<div class="light-effect-container mt-xl">
					<span id="lightEffect" class="light-effect" style="--radius:600px;"></span>
					<input type="submit" value="Register" class="btn btn-xl btn-sharp btn-outline-primary btn-span" />
				</div>
			</div>
		</form>
	</main>
