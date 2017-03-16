<?php

/* Redirect user
 * A User must be logged in to access the admin folder.
 * This script redirects a user that is not logged in.
 * This relies on the write_URL function.
 */

function redirect_user($page = 'index', $query = array(), $secure = FALSE) {
	
	// Define the URL.
	if ($secure) {
		$url = SECURE_URL . write_URL($page, $query);
	} else {
		$url = BASE_URL . write_URL($page, $query);
	}

 	// Redirect the user:
 	header("Location: $url");
 	exit(); // Quit the script.

 } // End of redirect_user() function.
 
 
/* URL rewriting
 * Depending on the configuration, the URLs will be written in a different style.
 * This is useful for hard coded URLs.
 */

function write_URL($p, $params = array()) {
	
	$param_str = NULL;
	
	if (URL_REWRITING) {
		if (!empty($params)) {
			foreach ($params as $k => $v) {
				$param_str .= '/' . $v;
			}
		}
		if ($p == 'index') {
			return '/index' . $param_str;
		} elseif ($p == 'admin') {
			return '/admin/index';
		}
		
		return '/' . $p . $param_str;
		
	} else {

		if (!empty($params)) {
			foreach ($params as $k => $v) {
				$param_str .= '&' . $k . '=' . $v;
			}
		}
	
		if ($p == 'index') {
			return '/index.php' . $param_str;
		} elseif ($p == 'admin') {
			return '/admin/index.php';
		}
		return '/index.php?p=' . $p . $param_str;
		
	}

}

/* Create form inputs
 *
 */
function create_form_input($name, $type, $label = '', $errors = array(), $options = array()) {
	$value = false;
	if (isset($_POST['name'])) $value = $_POST['name'];
	if ($value && get_magic_quotes_gpc()) $value = stripslashes($value);
	
	echo '<div class="form-group';
	if (array_key_exists($name, $errors)) echo ' has-error';
	echo '">';
	
	if (!empty($label)) echo '<label for="' . $name . '" class="control-label">' . $label . '</label>';
	
	if ( ($type === 'text') || ($type === 'password') || ($type === 'email' )) {
		echo '<input type="' .$type . '" name="' . $name . '" id="' . $name . '" class="form-control"';
	
		if ($value) echo ' value="' . htmlspecialchars($value) . '"';
	
		if (!empty($options) && is_array($options)) {
			foreach ($options as $k => $v) {
				echo " $k=\"$v\"";
			}
		}
	
		echo '>';
	
		if (array_key_exists($name, $errors)) echo '<span class="help-block">' . $errors[$name] . '</span>';
		
	} elseif ($type === 'textarea') {
		
		if (array_key_exists($name, $errors)) echo '<span class="help-block">' . $errors[$name] . '</span>';
		
		echo '<textarea name="' . $name . '" id="' . $name . '" class="form-control"';
		
		if (!empty($options) && is_array($options)) {
			foreach ($options as $k => $v) {
				echo " $k=\"$v\"";
			}
		}
		
		echo '>';
		
		if ($value) echo $value;
		
		echo '</textarea>';
		
	}
	
	echo '</div>';
	
} // End of the create_form_input() function.


/* Generate a random number and hash it.
 * Used for generating usernames, renaming avatars, etc.
 * This generates a 40 character string.
 */

function random_hash() {
	$random = rand(1, 1000) + time() + 'RH6N#gY5GP$l4D#(_4x.bn:=jw2H7L';
	for ($i = 0; $i < 50; $i += 1) {
		$random = hash ('sha1', $random, FALSE);
	}
	return $random;
}

/* Show a system error.
 */

function system_error() {
	echo 'A system error occurred. We apologize for the inconvenience.';
}

/* Get the IP address for the user.
 * Used to track access attempt, donations, etc.
 * The IP address can be spoofed, so this should not be used where accurate IPs are needed.
 *
 * Read more: http://techtalk.virendrachandak.com/getting-real-client-ip-address-in-php-2/#ixzz393vOUZ7O 
 * Follow us: @virendrachandak on Twitter
 */
 
function get_client_ip() {
	
	$ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;

}


// A function to test whether the fundraiser has subscribed to emails.
function check_fundraiser_email_subscription( $dbc, $user_id ) {
	
	if ( is_numeric( $user_id )) {

		// Check to see whether the user has subscribed to emails.
		$q = "SELECT id FROM fundraiser_email_subscribers WHERE user_id='$user_id'";
		$r = mysqli_query($dbc, $q);

		// If there is a result, set the settings value to TRUE.
		if (mysqli_num_rows($r) === 1) {
			mysqli_free_result($r);
			return TRUE;
		} else {
			mysqli_free_result($r);
			return FALSE;
		}
	
	}
	
	return FALSE;

}

// A function to test whether an email address is in the list of email subscribers.
function check_email_subscription( $dbc, $email ) {
	
	// Use a prepared statement to query the database.
	$q = "SELECT u.id FROM fundraiser_email_subscribers AS fes
	LEFT JOIN users AS u ON u.id=fes.user_id
	WHERE u.email=?";
	
	$stmt = mysqli_prepare( $dbc, $q );
	
	mysqli_stmt_bind_param( $stmt, 's', $email );
	mysqli_stmt_execute( $stmt );
	mysqli_stmt_store_result( $stmt );
	
	if ( mysqli_stmt_num_rows( $stmt ) === 0 ) {
		return FALSE; // The email is NOT on the list.
	}
	
	// The email is on the list.
	return TRUE;
	
}