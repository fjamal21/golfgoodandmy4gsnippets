<?php
/* 
 * 		This is a router file for the login module.
 *
 *		The login module contains basic login functioning: a template file to display a form
 * 		and a processor for the login form. It also has a "forgotpassword" component (view and controller)
 * 		and a "reset password" component (view and controller).
 *
 * 		To access the module, there must be a $_GET/$_POST p value of 'login'. This directs to the login page.
 *		To access the forgot password sub-component, there must be a $_GET/$_POST s value of 'forgotpassword'.
 *		To access the reset password sub-component, there must be a $_GET/$_POST s value of 'resetpassword',
 *		and an access key 'x' supplied in the URL.
 */

// All components of the login module are located in the core/login module.
// The directory is defined once.
$dir = 'core/login/';

// Check if the user is calling a sub-component. Otherwise, set the sub-component variable to NULL.
if (isset($_GET['s'])) {
	$s = $_GET['s'];
} elseif (isset($_POST['s'])) {
	$s = $_POST['s'];
} else {
	$s = NULL;
}

// If the user is calling the "reset password" sub-component, make sure there is an email hash and a key.
if ($s == 'resetpassword') {
	if (isset($_GET['x']) && strlen($_GET['x']) == 64) {
		$token = $_GET['x'];
	} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Let the include file take care of it.
	} else {
		$s = $token = NULL; // Incorrectly accessed the resetpassword page.
	}
}

// Choose the correct sub-component based on the value of $s. The default is the main login page.
switch ($s) {
	case 'forgotpassword':
		$page = 'forgot-password.inc.php';
		$page_title = 'Forgot Password';
		break;
	case 'resetpassword':
		$page = 'reset-password.inc.php';
		$page_title = 'Reset Password';
		break;
	default:
		$page = 'login.inc.php';
		$page_title = 'Sign In';
		break;
}

// Now include the correct page.
// Make sure the file exists.
if (!file_exists($dir . $page)) {
	$page = 'login.inc.php';
	$page_title = 'Sign In';
}
include ($dir . $page);