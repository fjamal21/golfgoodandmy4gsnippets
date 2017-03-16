<?php
/*
 *		This is a display file to view a list of donors and donations.
 */

// Get the admin header.
include ('core/common/header.tpl.php');

// Get the module header.
include('modules/donations/includes/header.tpl.php');



// Make sure there are donations.
if (!empty($donations)) {
	
	// What is the sub page?
	
	// If it's charities, show them. Otherwise, show the list of donors.
	if ($a == 'charities') {
		
	
		// Create a table to list donations.
		echo '
			<table>
				<tr>
					<th>Charity</th>
					<th>Total Donations</th>
				<tr>
		';
		
		// Output the list of charities and total donations.
		foreach ($donations as $donation) {
			
			// Create a new row.
			echo '
				<tr>
			';
		
			// Charity name
			echo '
					<td>' . $donation['name'] . '</td>
			';
		
			// Donation amount
			echo '
					<td>$' . number_format (($donation['total_donations']/100), 2) . '</td>
				</tr>
			';
		
		}
	
		// Close the table.
		echo '
			</table>
		';
		
	}
	else {

	
		// Create a table to list donations.
		echo '
			<table>
				<tr>
					<th>Receipt</th>
					<th>Donation</th>
					<th>Donor</th>
					<th>Fundraiser</th>
					<th>Charity</th>
					<th>Date</th>
				<tr>
		';
	
		// Output the list of donors and donations.
		foreach ($donations AS $donation) {
		
			// Create a new row.
			echo '
				<tr>
			';
		
			// Receipt number
			 echo '
					<td><a href="' . SECURE_URL . write_URL('donate', array('s' => 'receipt', 'x' => urlencode($donation['email']), 'y' => $donation['receipt_key'])) . '">' . substr($donation['receipt_key'], 0, 10) . '</a></td>
			';
		
			// Donation amount
			echo '
					<td>$' . number_format (($donation['total_donation']/100), 2) . '</td>
			';
		
			// Donor name and email
			echo '
					<td>' . $donation['first_name'] . ' ' . $donation['last_name'] . ' (' . $donation['email'] . ')</td>
			';
		
			// Fundraiser name and email
			echo '
					<td><a href="' . BASE_URL . write_URL('p', array('s' => $donation['guid'])) . '">' . $donation['user_first_name'] . ' ' . $donation['user_last_name'] . '</a> (' . $donation['user_email'] . ')</td>
			';
		
			// Charity name
			echo '
					<td>' . $donation['name'] . '</td>
			';
		
			// Donation date
			echo '
					<td>' . $donation['date_created'] . '</td>
				</tr>
			';
		
		}
	
		// Close the table.
		echo '
			</table>
		';
		
	}
	
} else {
	
	// No donations.
	echo '
		<p>No donations have been made</p>
	';
	
}