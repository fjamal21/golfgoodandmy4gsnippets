<?php
/*
 *		This file is include by the control file for the login module.
 *		It is called if the $_GET/$_POST sub-component variable s is 'forgotpassword'.
 */

$success = FALSE;
$forgot_password_errors = array();

// Check for a form submission.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// Process the form.
	// Check if the email exists in the database. Otherwise, log an error.
	if (empty($_POST['email'])) {
		$forgot_password_errors['email'] = "Please enter your email address.";
	} else {
		$e = $_POST['email'];
	}
	
	// If there was am email, then proceed.
	if (empty($forgot_password_errors)) {

		// Create a prepared statement to check the database for this email.
		//$q = "SELECT id FROM users WHERE email=?";
		//$stmt = mysqli_prepare($dbc, $q);
			
		//mysqli_stmt_bind_param($stmt, 's', $e);
		//mysqli_stmt_execute($stmt);
		//mysqli_stmt_store_result($stmt);
        
		$q = "SELECT id FROM users WHERE email=:email";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':email', $e);
        $sh->execute();
		
		//if (mysqli_stmt_num_rows($stmt) == 1) { // There was a result.
		if ($sh->rowCount() == 1) { // There was a result.
			
			// Get the user id to associate with the access token.
			//mysqli_stmt_bind_result($stmt, $user_id);
			//mysqli_stmt_fetch($stmt);
			//mysqli_stmt_close($stmt);
            
			list($user_id) = $sh->fetch(\PDO::FETCH_NUM);
			
			// Create the access token.
			$token = openssl_random_pseudo_bytes(32);
			$token = bin2hex($token);
			
			
			// Check if there is an existing access token for this email.
			//$q = "SELECT date_expires FROM access_tokens WHERE user_id='$user_id'";
			//$r = mysqli_query($dbc, $q);
            

			$q = "SELECT date_expires FROM login_tokens WHERE user_id=:user_id";
            
            $sh = $pdo->prepare($q);
            $sh->bindParam(':user_id', $user_id);
            $sh->execute();
			
			// If there is no result, create a new token.
			//if (mysqli_num_rows($r) == 0) {
			if ($sh->rowCount() == 0) {
				
				// Input the access token into the database.
				//$q = "INSERT INTO access_tokens (user_id, token, date_expires) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE))";
				//$stmt = mysqli_prepare($dbc, $q);
				//mysqli_stmt_bind_param($stmt, 'is', $user_id, $token);
				//mysqli_stmt_execute($stmt);
                
                
				$q = "INSERT INTO login_tokens (
                    user_id,
                    token,
                    date_expires
                ) VALUES (
                    :user_id,
                    :token,
                    DATE_ADD(NOW(), INTERVAL 60 MINUTE)
                )";

                $sh = $pdo->prepare($q);
                $sh->bindParam(':user_id', $user_id);
                $sh->bindParam(':token', $token);
                $sh->execute();
				
			} else {
				
				// There is a result, so perform an update.
				//$q = "UPDATE access_tokens SET token=?, date_expires=(DATE_ADD(NOW(), INTERVAL 15 MINUTE)) WHERE user_id=?";
				//$stmt = mysqli_prepare($dbc, $q);
				
				//mysqli_stmt_bind_param($stmt, 'si', $token, $user_id);
				//mysqli_stmt_execute($stmt);
                

				$q = "UPDATE login_tokens SET token=:token, date_expires=(DATE_ADD(NOW(), INTERVAL 60 MINUTE)) WHERE user_id=:user_id";
                
                $sh = $pdo->prepare($q);
                $sh->bindParam(':token', $token);
                $sh->bindParam(':user_id', $user_id);
                $sh->execute();
				
			}
			
			
			//if (mysqli_stmt_affected_rows($stmt) == 1) { // The row was inserted/updated.
			if ($sh->rowCount() == 1) { // The row was inserted/updated.
				
				// Create the URL for reseting the password.
				//$url = SECURE_URL . write_URL('login', array('s' => 'resetpassword', 'x' => $token));
				$url = $config->get('secure_url') . '/resetpassword/' . $token;
				
				// Create the email fields.
				$to = $e;
				$subject = 'Password reset from ' . $config->get('site_name');
				$body = 'This email is in response to a forgotten password reset request at ' . $config->get('site_name') . '.';
				$body .= "
If you made this request, then click the following link to reset your password and access your account:

$url

For security purposes, you have 15 minutes to use this link before it expires.

If you did not request a password reset, you can ignore this email and sign in with your existing password.
				";

				$from = $config->get('site_email');
				
				mail ($to, $subject, $body, 'From: ' . $from);
				
				$success = TRUE;
	
			} else {
				$forgot_password_errors['general'] = "A system error occurred. Please try again.";
			}
			
		}
		
	}
	
	
} // End of form submission if.

include 'forgot-password.tpl.php';