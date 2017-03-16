<?php
/*
 *		This script is processes the access to or form submission for a password reset.
 *
 *		It is accessed by the login controller file if the sub-component s value is 'resetpassword'.
 *		Additionally, the file requires a access token 'x' that is a 64 character string.
 */

$access_error = NULL;
$password_reset_errors = array();
$success = FALSE;

// If the page is access with the access token in the URL, then check for the access token.
// This also logs the user in.
// Check the database for the access token.
if (isset($_GET['token'])) {

    $token = $_GET['token'];

	$q = "SELECT
        u.id,
        u.username,
        u.activation_key
    FROM users AS u
	LEFT JOIN login_tokens AS at ON at.user_id=u.id
	WHERE at.token=:token AND at.date_expires > NOW()";
        
    $sh = $pdo->prepare($q);
    $sh->bindParam(':token', $token);
    $sh->execute();
        
	if ($sh->rowCount() == 1) { // There is a result.
        
		list( $user_id, $username, $active ) = $sh->fetch(\PDO::FETCH_NUM);
        
		// Check if the account has been activated.
		if ($active == NULL) { // An active account has a NULL value.
	
			// Reset the session id.
			$session->regenerate();
			
			// Set the session values.
            $session->set('user_id', $user_id);
			$session->set('username', $username);
			$session->set('user_type', 1);
			
			// Store the HTTP_USER_AGENT.
			$session->set('agent', md5($_SERVER['HTTP_USER_AGENT']));
			
			// Delete the token from the database.
			$q = "DELETE FROM access_tokens WHERE token=:token";
            $sh = $pdo->prepare($q);
            $sh->bindParam(':token', $token);
            $sh->execute();
			
		} else {
			$access_error = 'You\'re account has not been activated. Please check your email for activation instructions.';
		}
		
	} else {
		$access_error = 'Either your access token doesn\'t match the one on file or your time has expired. Please resubmit the <a href="/forgotpassword">Forgot Password</a> form.';
	}
	
} else {
    exit('This page has been accessed in error.');
}

// If the form has been submitted, then process it.
// Since the session values are set on access, also check for a user id.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
	
    $user_id = $session->get('user_id');
    
	// Validate the passwords.
	if (preg_match('/^(.){6,}$/', $_POST['pass1'])) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$pass = $_POST['pass1'];
		} else {
			$reset_password_errors['pass2'] = 'Your password did not match the confirmed password.';
		}
	} else {
		$reset_password_errors['pass1'] = "Your password must be at least 6 characters.";
	}
	
	// If there are no errors, update the database.
	if (empty($reset_password_errors)) {
		
		// For PHP versions < 5.5, get the password_compat library.
		require SRC . 'Lib/password.php';
		
		// Hash the password.
		$pass = password_hash($pass, PASSWORD_DEFAULT);
		
		// Create the query.
		$q = "UPDATE users SET pass=:pass WHERE id=:user_id LIMIT 1";
        $sh = $pdo->prepare($q);
        $sh->bindParam(':pass', $pass);
        $sh->bindParam(':user_id', $user_id);
        $sh->execute();
		
		//if (mysqli_stmt_affected_rows($stmt) === 1) {
		if ($sh->rowCount() == 1) {
			
			//mysqli_stmt_close($stmt);
			
			$success = true;
			
			// Send an email to the user confirming this change.
			// Get the email address.

			$q = "SELECT email FROM users WHERE id=:user_id";
            $sh = $pdo->prepare($q);
            $sh->bindParam(':user_id', $user_id);
            $sh->execute();
			
			// If there is a result, then get it and send the email.
			//if (mysqli_stmt_num_rows($stmt) === 1) {
    		if ($sh->rowCount() == 1) {
                
                list($email) = $sh->fetch(\PDO::FETCH_NUM);
				
				// Create the email fields.
				$to = $email;
				$subject = "Givegolf Password Reset";
				$body = "Your password to Givegolf for Brain Health has been changed.

If this wasn't you, please contact us immediately at admin@givegolf.ca and we will secure your account.";
				$from = $config->get('site_email');
				
				// Send the email.
				mail($email, $subject, $body, 'From: ' . $from);
				
			}
			
		}
		
	}
	
}

include 'reset-password.tpl.php';