<?php
/*
 *		This file is the root file for adding a donation to the database.
 *		It is a business logic and router file.
 *
 *		A user must be able to identify the fundraiser to attach the donation to.
 *		This requires some method of selection. For few fundraisers, a select box is OK.
 *		A more advanced case would be to perform a search, which can be done with a MySQL LIKE query on the first and last name, email address, or profile guid.
 *
 *		This file must update:
 *		- donors
 *		- donations
 *		- donation_contents
 *		- donor_addresses
 *		- user_raise
 *
 *		A more complete implementation would allow the user to choose to send an email to
 *		- the fundraiser ("A new donation has been added.")
 *		- the donor ("Your donation has been processed.")
 *
 *		This could also create donor store keys, if the module is being used.
 */


// Set variables.
$module = 'donations';
$users = array();
$donations_errors = array();
$success = FALSE;

// Include the provinces file to get arrays of provinces and states.
include ('includes/provinces.inc.php');


// Get the list of fundraisers and advocates. Complete profiles only.
// The holes goal is needed for the add process, so this look-up is done first.
$q = "SELECT u.id, u.first_name, u.last_name, u.email, up.guid, up.goal_holes FROM users AS u 
LEFT JOIN user_profiles AS up ON up.id=u.id
WHERE type IN (1, 50, 75) AND up.guid IS NOT NULL";
$r = mysqli_query($dbc, $q);

if (mysqli_num_rows($r) != 0) { // There are results.
	
	// Initialize a counter.
	$i = 0;
	
	// Reassign the values to the users array.
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		
		foreach ($row as $k => $v) {
			$users[$i][$k] = $v;
		}
		
		// Increment the counter.
		$i += 1;
		
	}
}


// Check for a form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// Include the add process to attempt to process the form submission.
	include ('modules/' . $module . '/includes/add.inc.php');
	
}


// Include the display file.
include ('modules/' . $module . '/add_donation.tpl.php');

?>