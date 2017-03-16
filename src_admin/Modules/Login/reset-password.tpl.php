<?php
/*
 *		This page displays the template for a password reset.
 *		It is called by the resetpassword.inc.php file.
 */

include SRC . '/views/header-simple.tpl.php';

// Create a container.
echo '
	<div class="modal-small">
';

// If there is an access error, display it.
if ($access_error) {
	
	echo '
		<h1>Reset your password</h1>
	';
	
	echo '
		<div class="modal-wrap">
	';
	
	echo '
		<p>' . $access_error . '</p>
	';
	
} elseif ($success) {
	// If the update was successful, show a message.
	
	echo '
		<h1>Password Reset</h1>
	';
	
	echo '
		<div class="modal-wrap">
	';
	
	echo '
		<p>Your password has been successfully reset.</p>
		<p><a href="/profile">View your Profile</a></p>
	';
	
} else {
	// Otherwise, show the form.
	echo '
		<h1>Reset your password</h1>
	
		<div class="modal-wrap">
		
			<p>Complete the form below to create a new password for your account.</p>
	';

	// Open the form.
	echo '
		<form action="" method="post">
	';

	// Create the password input.
	echo '
		<div class="form-input';
	if (isset($reset_password_errors['pass1'])) {
		echo ' input-error';
	}
	echo '"">
			<label for="pass1">New Password</label>
			<input type="password" name="pass1" id="pass1" />';
	if (isset($reset_password_errors['pass1'])) {
		echo '
			<span class="input-error-text">' . $reset_password_errors['pass1'] . '</span>
		';
	}
	echo '
		</div>
	';
	// Create the confirm password input.
	echo '
		<div class="form-input';
	if (isset($reset_password_errors['pass2'])) {
		echo ' input-error';
	}
	echo '"">
			<label for="pass2">Confirm Password</label>
			<input type="password" name="pass2" id="pass2" />';
	if (isset($reset_password_errors['pass2'])) {
		echo '
			<span class="input-error-text">' . $reset_password_errors['pass2'] . '</span>
		';
	}
	echo '
		</div>
	';

	// Include the page and sub-component references as hidden inputs.
	echo '
		<input type="hidden" name="p" value="login" />
		<input type="hidden" name="s" value="resetpassword" />
			
		<p><input type="submit" name="submit" value="Submit" /></p>
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

include SRC . 'views/footer-simple.tpl.php';