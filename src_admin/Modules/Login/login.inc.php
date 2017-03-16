<?php
/*
 * Descrition:
 * This file processes the sign in page.
 */

// Initialize variables.
$e = $pass = NULL;
$valid = FALSE; // Marker for checking the password.
$login_errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // The form is submitted.
	
	// Check for an email value.
	if (empty($_POST['email'])) {
		$login_errors['email'] = "Please enter your email address.";
	} else {
		$e = $_POST['email'];
	}
	
	// Check for a password value
	if (empty($_POST['pass'])) {
		$login_errors['pass'] = 'Please enter your password.';
	} else {
		$pass = $_POST['pass'];
	}
	
	// If there are no errors, then check the database for the user.
	if (empty($login_errors)) {
		
		// Create the query.
		//$q = "SELECT id, type, username, pass, active FROM users WHERE email=?";
		$q = "SELECT id, username, pass, activation_key FROM users WHERE email=:email";
		
        $sh = $pdo->prepare($q);
        $sh->bindParam(':email', $e);
        $sh->execute();
		//$stmt = mysqli_prepare($dbc, $q);
		//mysqli_stmt_bind_param($stmt, 's', $e);
		//mysqli_stmt_execute($stmt);
		//mysqli_stmt_store_result($stmt);
        
		// Check if there is a result.
		//if (mysqli_stmt_num_rows($stmt) === 1) { // There is a result.
		if ($sh->rowCount() == 1) { // There is a result.
            
			//mysqli_stmt_bind_result($stmt, $user_id, $user_type, $username, $hash, $active);
			//mysqli_stmt_fetch($stmt);
			//mysqli_stmt_close($stmt);
			list($user_id, $u, $hash, $active) = $sh->fetch(\PDO::FETCH_NUM);
			
			// For PHP versions < 5.5, get the password_compat library.
			require SRC . 'Lib/password.php';
			
			// Check if the submitted password matches the stored password.
			$valid = password_verify($pass, $hash);
			
			if ($valid) { // The passwords match.
				
				// Check if the account has been activated.
				if ($active == NULL) { // An active account has a NULL value.
					
					// Set the session values.
                    $session->set('user_id', $user_id);
    				$session->set('username', $u);
    				$session->set('user_type', 1);
    				//$_SESSION['user_id'] = $user_id;
    				//$_SESSION['username'] = $u;
    				//$_SESSION['user_type'] = 1;
				
    				// Store the HTTP_USER_AGENT.
    				$session->set('agent', md5($_SERVER['HTTP_USER_AGENT']));
			
					// The user is successfully logged in.
					// Redirect the user based on user type.
					//if ($user_type < 100) { // Non-admin users get directed to their Profile page.
					//	redirect_user('profile');
					//} else {
					//	redirect_user('admin');
					//}
                    header('Location: /index');
                    exit;
					
				} else {
					$login_errors['general'] = 'You\'re account has not been activated. Please check your email for activation instructions.';
				}
					
			} else { // No result in the database.
				$login_errors['general'] = "The email and password you entered do not match those on file. Please try again.";
			}
			
		} else { // No result in the database.
			$login_errors['general'] = "The email and password you entered do not match those on file. Please try again.";
		}
		
	} // End of empty($login_errors) IF.
	
}

include 'login.tpl.php';