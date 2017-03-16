<?php
/*
 *		This is a template file displaying the 'forgot password' form.
 *
 *		This file is included by the forgot-password include file.
 *		On first visit, it displays the form. On successful submission, it displays a
 *		Confirmation message.
 */

include SRC . 'views/header.tpl.php';

// Create a container.
echo '
	<div class="modal-small">
';

if ($success) {
	
	echo '
		<h1>Help is on the way!</h1>
	';
	
	echo '
		<div class="modal-wrap">
	';
	echo '
		<p>Please check your email. We\'ve sent instructions to help you access your account.</p>
	';
	
} else {
	
	echo '
		<h1>Forgot Password?</h1>
	';
	
	echo '
		<div class="modal-wrap">
	';
	
	echo '
		<p>Enter your email below and we\'ll send you instructions for accessing your account.</p>
	';
	
	if (isset($forgot_password_errors['general'])) {
		echo '
			<p class="form-error">' . $forgot_password_errors['general'] . '</p>
		';
	}
	
	// Open the form.
	echo '
		<form action="" method="post">
	';
	
	// Create the email input.
	echo '
			<div';
	if (isset($forgot_password_errors['email'])) {
		echo ' class="input-error"';
	}
	echo '>
				<label for="email">Email</label>
				<input type="email" name="email" id="email"';
			
	if (isset($_POST['email'])) echo ' value="' . htmlspecialchars($_POST['email']) . '"';
	echo ' />';
	if (isset($forgot_password_errors['email'])) {
		echo '
				<span class="input-error-text">' . $forgot_password_errors['email'] . '</span>
		';
	}
	echo '
			</div>
	';
	
	echo '
			<p><input type="submit" name="submit" value="Submit" /></p>
	
			<input type="hidden" name="p" value="login">
			<input type="hidden" name="s" value="forgotpassword">
	
			<p><a href="/login">Back to Sign In</a></p>
	';
	
	// Close the form.
	echo '
		</form>
	';
}

// Close the container.
echo '
		</div>
	</div>
';

include SRC . 'views/footer.tpl.php';