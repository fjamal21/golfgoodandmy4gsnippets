<?php
	
include SRC . 'views/header.tpl.php';


// Create a container.
echo '
	<div class="modal-small">
';
?>

<h1>Login</h1>

<div class="modal-wrap">
	
<?php if (isset($login_errors['general'])) echo '<p class="form-error">' . $login_errors['general'] . '</p>'; ?>
<form action="" method="post">
	
	<?php
	
	// Create the email input.
	echo '
		<div';
	if (isset($login_errors['email'])) {
		echo ' class="input-error"';
	}
	echo '>
			<label for="email">Email</label>
			<input type="email" name="email" id="email"';
			
	if (isset($_POST['email'])) echo ' value="' . htmlspecialchars($_POST['email']) . '"';
	echo ' />';
	if (isset($login_errors['email'])) {
		echo '
			<span class="input-error-text">' . $login_errors['email'] . '</span>
		';
	}
	echo '
		</div>
	';
	
	// Create the password input.
	echo '
		<div class="form-input';
	if (isset($login_errors['pass'])) {
		echo ' input-error';
	}
	echo '"">
			<label for="pass">Password</label>
			<span class="input-help-link"><a href="forgotpassword">Forgot Password?</a></span>
			<input type="password" name="pass" id="pass" />';
	if (isset($login_errors['pass'])) {
		echo '
			<span class="input-error-text">' . $login_errors['pass'] . '</span>
		';
	}
	echo '
		</div>
	';
	
	?>
	
	<p><input type="submit" name="submit" value="Login" /></p>
	
	<input type="hidden" name="p" value="login">
	
	
</form>

</div>
<?php

// Close the container.
echo '
	</div>
';

include SRC . 'views/footer.tpl.php';
