<?php
/*
 *		This file is the template file for adding a donation to the database.
 */




// Get the admin header.
include ('core/common/header.tpl.php');

// Get the module header.
include('modules/donations/includes/header.tpl.php');

// If the donation was saved successfully, show a message.
if ($success) {
	echo '<p class="form-success">The Donation has been saved.</p>';
}

// If there are errors, display them.
if (!empty($donations_errors)) {
	echo '<p class="form-error">' . implode('<br />', $donations_errors) . '</p>';
}

// Show a generic message explaining how to use the page.
echo '
	<p>Use this form manually add donations given as cash or check.</p>
';


// BEGIN form
echo '
	<form action="' . BASE_URL . '/admin' . write_URL('index') . '" method="post">
';

// Include hidden variables to get back to the right page.
echo '
	<input type="hidden" name="p" value="donations" />
	<input type="hidden" name="action" value="add" />
';


// Select the fundraiser.
echo '
	<div>
		<label for="fundraiser">Select the Fundraiser <span class="form-required-marker">*</span></label>
		<select name="fundraiser">
			<option>Select</option>
';

// Create a list of fundraisers in the options.
foreach ($users as $user) {
	echo '
			<option value="' . $user['id'] . '"';
	
	// Check if the fundraiser is selected.
	if (isset($donations['fundraiser_id']) && $donations['fundraiser_id'] == $user['id']) {
		echo ' selected="selected"';
	}
	
	echo '>' . $user['first_name'] . ' ' . $user['last_name'] . ' (' . $user['email'] . ')</option>
	';
}

echo '
		</select>
	</div>
';


// Create the donation amount input.
echo '
	<div>
		<label for="donation_amount">Donation Amount <span class="form-required-marker">*</span><br /><span class="form-help-text">Provide the dollar amount that is being donated to this fundraiser.</span></label>
		<input type="text" name="donation_amount" id="donation_amount"';
		
if (isset($donations['total_donation'])) echo ' value="' . round ( ($donations['total_donation'] / 100), 2) . '"';
echo ' />
	</div>
';



// --------------------------------------------- //
// ------------ Donor information -------------- //
echo '
	<h2>Donor Information</h2>
';

// Donor first name
echo '
	<div>
		<label for="first_name">First Name <span class="form-required-marker">*</span><br /></label>
		<input type="text" name="first_name" id="first_name"';
		
if (isset($donations['first_name'])) echo ' value="' . $donations['first_name'] . '"';
echo ' />
	</div>
';


// Donor last name
echo '
	<div>
		<label for="last_name">Last Name <span class="form-required-marker">*</span><br /></label>
		<input type="text" name="last_name" id="last_name"';
		
if (isset($donations['last_name'])) echo ' value="' . $donations['last_name'] . '"';
echo ' />
	</div>
';


// Donor email
echo '
	<div>
		<label for="email">Email <span class="form-required-marker">*</span><br /></label>
		<input type="email" name="email" id="email"';
		
if (isset($donations['email'])) echo ' value="' . $donations['email'] . '"';
echo ' />
	</div>
';

// Donor phone number
echo '
	<div>
		<label for="phone_number">Phone Number <span class="form-required-marker">*</span><br /></label>
		<input type="tel" name="phone_number" id="phone_number"';
		
if (isset($donations['phone_number'])) echo ' value="' . $donations['phone_number'] . '"';
echo ' />
	</div>
';

// ------------ Donor information -------------- //
// --------------------------------------------- //




// --------------------------------------------- //
// ------------- Donor address ----------------- //

echo '
	<h2>Donor Address</h2>
';

// Street address
echo '
	<div>
		<label for="address">Address <span class="form-required-marker">*</span><br /></label>
		<input type="text" name="address" id="address"';
		
if (isset($donations['address'])) echo ' value="' . $donations['address'] . '"';
echo ' />
	</div>
';


// City
echo '
	<div>
		<label for="city">City <span class="form-required-marker">*</span><br /></label>
		<input type="text" name="city" id="city"';
		
if (isset($donations['city'])) echo ' value="' . $donations['city'] . '"';
echo ' />
	</div>
';


// Province/State
echo '
	<div>
		<label for="province">Province or State <span class="form-required-marker">*</span><br /></label>
								
		<select name="province" id="province">
			<option>Select</option>
			<optgroup label="Provinces">
';
		
foreach ($provinces as $k => $v) {
	
	// For now, this is Canada and United States.
	echo '
				<option value="' . $k . '"';
	if ((isset($_POST['province']) && $_POST['province'] == $k)) {
		echo ' selected="selected"';
	}

	echo '>' . $v . '</option>
	';
	
}
		
echo '
			</optgroup>
			<optgroup label="States">
';
		
foreach ($states as $k => $v) {
	
	// For now, this is Canada and United States.
	echo '
				<option value="' . $k . '"';
	if ((isset($_POST['province']) && $_POST['province'] == $k)) {
		echo ' selected="selected"';
	}

	echo '>' . $v . '</option>
	';
	
}

echo '
			</optgroup>
		</select>
	</div>
';


// Country
echo '
	<div>
		<label for="country">Country <span class="form-required-marker">*</span><br /></label>
		<select name="country" id="country">
';

// For now, this is Canada and United States.
echo '
			<option value="Canada"';
if ((isset($donations['country']) && $donations['country'] == 'Canada') || !isset($donations['country'])) {
	echo ' selected="selected"';
}

echo '>Canada</option>
';
echo '
								<option value="United States"';
if (isset($donations['country']) && $donations['country'] == 'United States') {
	echo ' selected="selected"';
}

echo '>United States</option>
';
		
echo '
		</select>
	</div>
';


// Postal/Zip Code
echo '
	<div>
		<label for="postal_code">Postal or Zip Code <span class="form-required-marker">*</span><br /></label>
		<input type="text" name="postal_code" id="postal_code"';
		
if (isset($donations['postal_code'])) echo ' value="' . $donations['postal_code'] . '"';
echo ' />
	</div>
';


// ------------- End Donor Address ------------- //
// --------------------------------------------- //



// --------------------------------------------- //
// ------------- Anonymity Settings ------------ //

echo '
	<h2>Anonymity Settings</h2>
';

// Create a checkbox
echo '
		<div>
';

// Create the button.
echo '
			<input type="checkbox" name="anonymous" id="anonymous" value="1"';

// Check for a selected button.
if (isset($donations['anonymous']) && $donations['anonymous'] == 1) {
	echo ' checked="checked"';
}

echo ' />
';

// Create the label.
echo '
			<label for="anonymous">Sponsor this fundraiser anonymously</label>
';

// Close the checkbox
echo '
		</div>
';


// Create a checkbox
echo '
		<div>
';

// Create the button.
echo '
			<input type="checkbox" name="hide_amount" id="hide_amount" value="1"';

// Check for a selected button.
if (isset($donations['hide_amount']) && $donations['hide_amount'] == 1) {
	echo ' checked="checked"';
}

echo ' />
';

// Create the label.
echo '
			<label for="hide_amount">Don\'t display my donation amount on the donors list</label>
';

// Close the checkbox
echo '
		</div>
';

// ------------- Anonymity Settings ------------ //
// --------------------------------------------- //




// Submit
echo '
	<p class="form-submission-options"><input type="submit" name="submit" value="Save" /> <a href="' . BASE_URL . '/admin' . write_URL('donations') . '">Cancel</a>';

echo '
	</form>
';

// END form


// Include the footer.
include ('core/common/footer.tpl.php');
?>