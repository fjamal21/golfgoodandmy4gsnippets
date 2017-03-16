<?php
/*
 *		This file is included by the add_donation file in order to process the addition.
 */

// Assume that donations are always a flat amount.


// If the form is submitted, get the selected fundraiser id.
if (isset($_POST['fundraiser']) && is_numeric($_POST['fundraiser'])) {
	$donations['fundraiser_id'] = $_POST['fundraiser'];

	// Sponsored holes is the current holes goal for the fundraiser.
	// Find the holes goal in the $users array.
	foreach ($users as $user) {
		if ($user['id'] == $donations['fundraiser_id']) {
			$donations['sponsored_holes'] = $user['goal_holes'];
			break;
		}
	}
	
	// If there isn't a holes goal for some reason, make one up.
	if (!isset($donations['goal_holes'])) {
		$donations['sponsored_holes'] = 100;
	}
	
} else {
	$donations_errors[] = 'Please select a fundraiser.';
}

// Get the donation amount.
if (isset($_POST['donation_amount']) && is_numeric($_POST['donation_amount']) && $_POST['donation_amount'] > 0) {
	
	// Set the donation amount in cents. Round to 0 decimal places.
	$donations['total_donation'] = round (($_POST['donation_amount'] * 100), 0);
	
} else {
	$donations_errors[] = 'Please enter a donation amount.';
}

// Validate the first name. Required.
if (!empty($_POST['first_name'])) {
	if (preg_match('/^[A-Z \'.-]{1,40}$/i', $_POST['first_name'])) {
		$donations['first_name'] = $_POST['first_name'];
	} else {
		$donations_errors['first_name'] = "The donor's first name can include letters, apostrophes, periods and hyphens.";
	}
} else {
	$donations_errors['first_name'] = "Please provide the donor's first name.";
}
// Validate the last_name. Required.
if (!empty($_POST['last_name'])) {
	if (preg_match('/^[A-Z \'.-]{1,40}$/i', $_POST['last_name'])) {
		$donations['last_name'] = $_POST['last_name'];
	} else {
		$donations_errors['last_name'] = "The donor's last name can include letters, apostrophes, periods and hyphens.";
	}
} else {
	$donations_errors['last_name'] = "Please provide the donor's last name.";
}

		
// Check for an email.
if (!empty($_POST['email'])) {
	
	// Validate the email.
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$donations['email'] = $_POST['email'];
	} else {
		$donations_errors['email'] = 'Please provide a valid email address.';
	}
	
} else {
	$donations_errors['email'] = 'Please provide an email address.';
}


// Phone number.
if (!empty($_POST['phone_number'])) {
	
	// Remove non-digits.
	$donations['phone_number'] = preg_replace('/[^0-9]/', '', $_POST['phone_number']);
	
	// Make sure it's 10 digits.
	if (strlen($donations['phone_number']) != 10) {
		$donations_errors['phone_number'] = 'Please provide a valid phone number.';
	}
	
} else {
	$donations_errors['phone_number'] = 'Please provide the donor\'s phone number.';
}



// Check address information.
// Street address
if (!empty($_POST['address'])) {
	if (preg_match('/^[A-Z0-9 \',.#-]{1,160}$/i', $_POST['address'])) {
		$donations['address'] = $_POST['address'];
	} else {
		$donations_errors['address'] = "Please provide the donor's street address.";
	}
} else {
	$donations_errors['address'] = "Please provide the donor's street address.";
}

// City
if (!empty($_POST['city'])) {
	if (preg_match('/^[A-Z \'.-]{1,60}$/i', $_POST['city'])) {
		$donations['city'] = $_POST['city'];
	} else {
		$donations_errors['city'] = "Please provide the donor's city.";
	}
} else {
	$donations_errors['city'] = "Please provide the donor's city.";
}

// State/Province
if (isset($_POST['province']) && !empty($_POST['province'])) {
	if (array_key_exists($_POST['province'], $provinces) || array_key_exists($_POST['province'], $states)) {
		$donations['province'] = $_POST['province'];
	} else {
		$donations_errors['province'] = "Please provide the donor's province or state.";
	}
} else {
	$donations_errors['province'] = "Please provide the donor's province or state.";
}


// Country
if (isset($_POST['country']) && !empty($_POST['country'])) {
	switch ($_POST['country']) {
		case 'Canada':
			$donations['country'] = 'Canada';
			break;
		case 'United States':
			$donations['country'] = 'United States';
			break;
		default:
			$donations_errors['country'] = "Please select the donor's country.";
	}
} else {
	$donations_errors['country'] = "Please select the donor's country.";
}


// Zip/Postal Code
// Check for the appropriate format based on the country selected.
if (!empty($_POST['postal_code'])) {
	
	// If the country is Canada, check for postal code format.
	if ($donations['country'] == 'canada') {
		
		// Make upper case
		$donations['postal_code'] = strtoupper($_POST['postal_code']);
		
		// Check for postal code format. Case insensitive.
		if (!preg_match('/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/i', $donations['postal_code'])) {
			$donations_errors['postal_code'] = 'Please provide a valid postal code.';
		}
		
	} elseif ($donations['country'] == 'united states') {
		
		// The country is United States, so check for US zip code format.
		if (preg_match('/^(\d{5}$)|(^\d{5}-\d{4})$/', $_POST['postal_code'])) {
			$donations['postal_code'] = $_POST['postal_code'];
		} else {
			$donations_errors['postal_code'] = 'Please provide a valid zip code.';
		}
		
	} else { // The country isn't set, so try both formats.
		
		// Make upper case
		$donations['postal_code'] = strtoupper($_POST['postal_code']);
		
		if (preg_match('/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/i', strtoupper($_POST['postal_code']))) {
			$donations['postal_code'] = strtoupper($_POST['postal_code']);
		} elseif (preg_match('/^(\d{5}$)|(^\d{5}-\d{4})$/', $_POST['postal_code'])) {
			$donations['postal_code'] = $_POST['postal_code'];
		} else {
			$donations_errors['postal_code'] = "Please provide the donor's postal or zip code.";
		}
		
	}
	
} else {
	$donations_errors['postal_code'] = "Please provide the donor's postal or zip code.";
}



// Check the anonymity setting.
if (isset($_POST['anonymous']) && !empty($_POST['anonymous'])) {
	$donations['anonymous'] = 1;
} else {
	$donations['anonymous'] = 0;
}
if (isset($_POST['hide_amount']) && !empty($_POST['hide_amount'])) {
	$donations['hide_amount'] = 1;
} else {
	$donations['hide_amount'] = 0;
}

// If there are no errors, then attempt to add the information to the database.
if (!$donations_errors) {
	
	
	// Add to donors.
	// Create a random key for receipt access.
	$donations['receipt_key'] = random_hash();
	
	// Insert a row in the donors table.
	$q = "INSERT INTO donors (email, first_name, last_name, anonymous, hide_amount, receipt_key) VALUES (?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 'sssiis', $donations['email'], $donations['first_name'], $donations['last_name'], $donations['anonymous'], $donations['hide_amount'], $donations['receipt_key']);
	mysqli_stmt_execute($stmt);
	
	// Assume success
	$donations['donor_id'] = mysqli_stmt_insert_id($stmt);
	mysqli_stmt_close($stmt);
	
	
	
	// Add to donations.
	// Insert a row in the donations table
	$q = "INSERT INTO donations (donor_id, fundraiser_id, total_donation) VALUES (?, ?, ?)";
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 'iii', $donations['donor_id'], $donations['fundraiser_id'], $donations['total_donation']);
	mysqli_stmt_execute($stmt);
	
	// Assume success.
	$donations['donation_id'] = mysqli_stmt_insert_id($stmt);
	mysqli_stmt_close($stmt);
	
	
	// Add to donation_contents.
	$q = "INSERT INTO donation_contents (donation_id, donation_per_hole, donation_flat_amount, sponsored_holes) VALUES (?, 0, ?, ?)";
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 'iii', $donations['donation_id'], $donations['total_donation'], $donations['sponsored_holes']);
	mysqli_stmt_execute($stmt);
	
	// Assume success.
	mysqli_stmt_close($stmt);
	
	
	// Add to donor_addresses.

	$q = "INSERT INTO donor_addresses (donor_id, address, city, province, postal_code, country, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 'isssssi', $donations['donor_id'], $donations['address'], $donations['city'], $donations['province'], $donations['postal_code'], $donations['country'], $donations['phone_number']);
	mysqli_stmt_execute($stmt);
	
	// Assume success.
	mysqli_stmt_close($stmt);
	
	
	
	// Add to user_raise.
	// Update the user_raise table for the new donation amount.
	// Check if there is an entry for the fundraiser id.
	$q = "SELECT raise FROM user_raise WHERE user_id='" . $donations['fundraiser_id'] . "'";
	$r = mysqli_query ($dbc, $q);
	
	if (mysqli_num_rows($r) == 1) { // There is a row. Update it.
		
		$q = "UPDATE user_raise SET raise=(raise + " . $donations['total_donation'] . ") WHERE user_id='" . $donations['fundraiser_id'] . "'";
		$r = mysqli_query($dbc, $q);
		
	} else { // No result. Add a row.
		
		$q = "INSERT INTO user_raise (user_id, raise) VALUES ('" . $donations['fundraiser_id'] . "', '" . $donations['total_donation'] . "')";
		$r = mysqli_query($dbc, $q);
		
	}
	
	// Assume success
	$success = TRUE;
	
	// Clear the donations array.
	$donations = array();
}

?>