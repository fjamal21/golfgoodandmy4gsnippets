<?php
namespace Src\Modules\Donations\Views;

use Src\Includes\SuperClasses\AbstractView;
use Src\Config\Config;
use Src\Includes\User;

class AddView extends AbstractView
{
    /*
     * Run
     */
    public function run()
    {
        $this->display();
    }
    
    /*
     * Display
     */
    protected function display()
    {
        $config = Config::getInstance();
        $user = User::getInstance();
        
        // Get the admin header.
        include SRC . 'views/header.tpl.php';

        // Get the module header.
        include SRC . 'Modules/Donations/includes/header.tpl.php';

        // If the donation was saved successfully, show a message.
        if ( isset( $this->data['success'] ) ) {
        	echo '<p class="form-success">The Donation has been saved.</p>';
        }

        // If there are errors, display them.
        if ( isset( $this->data['error'] ) ) {
        	echo '<p class="form-error">' . implode('<br />', $this->data['error']) . '</p>';
        }

        // Show a generic message explaining how to use the page.
        echo '
        	<p>Use this form manually add donations given as cash or check.</p>
        ';


        // BEGIN form
        echo '
        	<form action="" method="post">
        ';

        // Select the fundraiser.
        echo $this->getFundraiserSelection();


        // Create the donation amount input.
        echo '
        	<div>
        		<label for="amount">Donation Amount <span class="form-required-marker">*</span><br /><span class="form-help-text">Provide the dollar amount that is being donated to this fundraiser.</span></label>
        		<input type="text" name="amount" id="amount"';
		
        if (isset($this->data['amount'])) echo ' value="' . round ( ($this->data['amount'] / 100), 2) . '"';
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
		
        if (isset($this->data['first_name'])) echo ' value="' . $this->data['first_name'] . '"';
        echo ' />
        	</div>
        ';


        // Donor last name
        echo '
        	<div>
        		<label for="last_name">Last Name <span class="form-required-marker">*</span><br /></label>
        		<input type="text" name="last_name" id="last_name"';
		
        if (isset($this->data['last_name'])) echo ' value="' . $this->data['last_name'] . '"';
        echo ' />
        	</div>
        ';


        // Donor email
        echo '
        	<div>
        		<label for="email">Email <span class="form-required-marker">*</span><br /></label>
        		<input type="email" name="email" id="email"';
		
        if (isset($this->data['email'])) echo ' value="' . $this->data['email'] . '"';
        echo ' />
        	</div>
        ';

        // Donor phone number
        echo '
        	<div>
        		<label for="telephone">Phone Number <span class="form-required-marker">*</span><br /></label>
        		<input type="tel" name="telephone" id="telephone"';
		
        if (isset($this->data['telephone'])) echo ' value="' . $this->data['telephone'] . '"';
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
		
        if (isset($this->data['address'])) echo ' value="' . $this->data['address'] . '"';
        echo ' />
        	</div>
        ';


        // City
        echo '
        	<div>
        		<label for="city">City <span class="form-required-marker">*</span><br /></label>
        		<input type="text" name="city" id="city"';
		
        if (isset($this->data['city'])) echo ' value="' . $this->data['city'] . '"';
        echo ' />
        	</div>
        ';


        // Province/State
        echo $this->getRegionSelection();

        // Country
        echo '
        	<div>
        		<label for="country">Country <span class="form-required-marker">*</span><br /></label>
        		<select name="country" id="country">
        ';

        // For now, this is Canada and United States.
        echo '
        			<option value="CA"';
        if ((isset($this->data['country']) && $this->data['country'] == 'CA') || !isset($this->data['country'])) {
        	echo ' selected="selected"';
        }

        echo '>Canada</option>
        ';
        echo '
        								<option value="US"';
        if (isset($this->data['country']) && $this->data['country'] == 'US') {
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
		
        if (isset($this->data['postal_code'])) echo ' value="' . $this->data['postal_code'] . '"';
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
        			<input type="checkbox" name="anonymity" id="anonymity" value="1"';

        // Check for a selected button.
        if (isset($this->data['anonymity']) && $this->data['anonymity'] == 1) {
        	echo ' checked="checked"';
        }

        echo ' />
        ';

        // Create the label.
        echo '
        			<label for="anonymity">Sponsor this fundraiser anonymously</label>
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
        if (isset($this->data['hide_amount']) && $this->data['hide_amount'] == 1) {
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
        	<p class="form-submission-options"><input type="submit" name="submit" value="Save" /> <a href="/donations">Cancel</a>';

        echo '
        	</form>
        ';

        // END form


        // Include the footer.
        include SRC . 'views/footer.tpl.php';
        
    }
    
    /*
     * Create the fundraisers select input
     */
    protected function getFundraiserSelection()
    {
        $users_obj = $this->data['users'];
        $users = $users_obj->getData();
        
        $html = '
        	<div>
        		<label for="fundraiser">Select the Fundraiser <span class="form-required-marker">*</span></label>
        		<select name="fundraiser">
        			<option>Select</option>
        ';

        // Create a list of fundraisers in the options.
        foreach ($users as $user) {
        	$html .= '
        			<option value="' . $user['id'] . '"';
	
        	// Check if the fundraiser is selected.
        	if ( isset( $this->data['fundraiser'] ) && $this->data['fundraiser'] == $user['id']) {
        		$html .= ' selected="selected"';
        	}
	
        	$html .= '>' . $user['first_name'] . ' ' . $user['last_name'] . ' (' . $user['email'] . ')</option>
        	';
        }

        $html .= '
        		</select>
        	</div>
        ';
        
        return $html;
    }
    
    /*
     * Get the regions selection
     */
    protected function getRegionSelection()
    {
        $regions = $this->data['regions'];
        $provinces = $regions->get('provinces');
        $states = $regions->get('states');
        
        $html = '';
		
        $html .= '<div';
		if (isset($this->data['error']['region'])) {
			$html .= ' class="input-error"';
		}
		$html .= '>
								
                <label for="region">Province or State</label>
				<span class="select">
					<select name="region" id="region">
						<option value="">Select</option>
						<optgroup label="Provinces">
		';

		foreach ($provinces as $k => $v) {
	
			// For now, this is Canada and United States.
			$html .= '
						    <option value="' . $k . '"';
			if ((isset($_POST['region']) && $_POST['region'] == $k)) {
				$html .= ' selected="selected"';
			}

			$html .= '>' . $v . '</option>
			';
	
		}

		$html .= '
						</optgroup>
						<optgroup label="States">
		';

		foreach ($states as $k => $v) {
	
			// For now, this is Canada and United States.
			$html .= '
						    <option value="' . $k . '"';
			if ((isset($_POST['region']) && $_POST['region'] == $k)) {
				$html .= ' selected="selected"';
			}

			$html .= '>' . $v . '</option>
			';
	
		}

		$html .= '
						</optgroup>
					</select>
				</span>
		';

		if (isset($this->data['error']['region'])) {
			$html .= '
				<span class="input-error-text">' . $this->data['error']['region'] . '</span>
			';
		}
		$html .= '
			</div>
		';
        
        return $html;
    }
}
