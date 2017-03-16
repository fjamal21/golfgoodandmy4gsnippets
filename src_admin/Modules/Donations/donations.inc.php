<?php
/*
 *		This file calls the database to get a list of donations and donation information.
 */

// Initialize variables.
$donations = array();

// Check for an sub page value.
if (isset($_GET['action'])) {
	$a = $_GET['action'];
} elseif (isset($_POST['action'])) {
	$a = $_POST['action'];
} else {
	$a = NULL;
}

switch ($a) {
	case 'add':
		$a = 'add';
		break;
	case 'charities':
		$a = 'charities';
		break;
	default:
		$a = 'donors';
}

// If we're adding a donation, include the file.
if ($a == 'add') {
	include ('modules/donations/add_donation.inc.php');
}
elseif ($a == 'charities') {
	// If we want the list of charities, then get it.

	// Total up the monies raised for each charity.
	
	// Get the charities.
	$q = "SELECT id, name FROM charities WHERE status='published'";
	$r = mysqli_query($dbc, $q);
	
	if (mysqli_num_rows($r) != 0) {
		
		// Initialize a counter
		$i = 0;
		
		while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			
			// Reassign the row values.
			foreach ($row as $k => $v) {
				$donations[$i][$k] = $v;
			}
			
			// Get the total amount of donations for the charity
			$q = "SELECT SUM(dn.total_donation) AS total_donations FROM donations AS dn
			LEFT JOIN users_charities AS uc ON uc.user_id=dn.fundraiser_id
			WHERE uc.charity_id='" . $row['id'] . "'";
			$r2 = mysqli_query($dbc, $q);
			
			if (mysqli_num_rows($r2) == 1) {
				
				// Get the value
				list ($donations[$i]['total_donations']) = mysqli_fetch_array($r2, MYSQLI_NUM);
				
			}
			
			// Increment the counter
			$i += 1;
				
		}
		
	}

	// Include the display file.
	include ('modules/donations/donations.tpl.php');
		
}
else { // Otherwise, just get the list of donors

	// Get a list of donors and donations.
	$q = "SELECT d.first_name,
		d.last_name,
		d.email,
		d.date_created,
		d.receipt_key,
		dn.total_donation,
		u.first_name AS user_first_name,
		u.last_name AS user_last_name,
		u.email AS user_email,
		up.guid,
		c.name
		FROM donors AS d
		LEFT JOIN donations AS dn ON dn.donor_id=d.id
		LEFT JOIN users AS u ON u.id=dn.fundraiser_id
		LEFT JOIN user_profiles AS up ON up.id=u.id
		LEFT JOIN users_charities AS uc ON uc.user_id=up.id
		LEFT JOIN charities AS c ON c.id=uc.charity_id";

	
	$r = mysqli_query($dbc, $q);

	// If there are values:
	if (mysqli_num_rows($r) != 0) {

		// Initialize a counter.
		$i = 0;

		// Reassign the mysql array to the $donations array.
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
			foreach ($row AS $k => $v) {
		
				$donations[$i][$k] = $v;
		
			}
	
			// Increment the counter
			$i += 1;
	
		}
	}
	
	// Include the display file.
	include ('modules/donations/donations.tpl.php');
		
}

