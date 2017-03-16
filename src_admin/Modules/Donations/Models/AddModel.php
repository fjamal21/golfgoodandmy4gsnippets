<?php
namespace Src\Modules\Donations\Models;

use Src\Includes\SuperClasses\AbstractModel;
use Src\Includes\Users;
use Src\Includes\UserProfile;
use Src\Includes\Donor;
use Src\Includes\Donation;
use Src\Includes\DonationContent;
use Src\Includes\DonationTransaction;
use Src\Includes\DonorAddress;
use Src\Includes\PostalCode;
use Src\Includes\ZipCode;
use Src\Includes\Arrays\Regions;

class AddModel extends AbstractModel
{
    /*
     * Objects
     */
    protected $users;
    protected $regions;
    protected $receipt_key;
    protected $donor;
    protected $donation;
    protected $donation_content;
    protected $donor_address;
    
    /*
     * Error marker
     */
    protected $error = false;
    
    /*
     * Run
     */
    public function run()
    {
        $this->setUsers();
        $this->regions = new Regions;
        $this->data['regions'] = $this->regions;

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->process();
        }
    }
    
    /*
     * Set the users
     */
    protected function setUsers()
    {
        $this->users = new Users;
        $this->users->read();
        
        $this->data['users'] = $this->users;
    }
    
    /*
     * Process the form submission
     */
    protected function process()
    {
        $this->setSubmittedValues();
    
        if ( $this->error ) {
            $this->data['error']['form'] = 'Please check for errors.';
            return;
        }
        
        $this->addPaymentToDatabase();
    }
    
    /*
     * Set submitted values
     */
    protected function setSubmittedValues()
    {
        if ( $this->setFundraiserId() ) {
            $this->setFundraiserProfile();   
        }

        $this->setAmount();
        
        $this->setFirstName();
        $this->setLastName();
        $this->setEmail();
        $this->setTelephone();
        
        $this->setAddress();
        $this->setCity();
        $this->setCountry();
        $this->setRegion();
        $this->setPostalCode();
        
        $this->setAnonymity();
        $this->setHideAmount();
    }
    
    /*
     * Set the fundraiser
     */
    protected function setFundraiserId()
    {
        if ( ! isset( $_POST['fundraiser'] ) ) {
            $this->error = true;
            $this->data['error']['fundraiser'] = 'Please select a fundraiser.';
            return false;
        }
        
        $id = trim( $_POST['fundraiser'] );
        
        if ( ! $this->users->isUser( $id ) ) {
            $this->error = true;
            $this->data['error']['fundraiser'] = 'Please select an existing fundraiser.';
            return false;
        }
        
        $this->data['fundraiser'] = $id;
        return true;
    }
    
    /*
     * Set the fundraiser profile
     */
    protected function setFundraiserProfile()
    {
        $this->fundraiser_profile = new UserProfile;
        $this->fundraiser_profile->set( 'user_id', $this->data['fundraiser'] );
        $this->fundraiser_profile->read();
    }
    
    /*
     * Set the donation amount
     */
    protected function setAmount()
    {
        if ( ! isset( $_POST['amount'] ) ) {
            $this->error = true;
            $this->data['error']['amount'] = 'Please enter a donation amount.';
            return;
        }
        
        $amount = trim( $_POST['amount'] );

        // Remove illegal characters
        $regex = '/[[^0-9.]]/';
        $value = preg_replace( $regex, '', $amount );
        
    	if ( $value && is_numeric( $value ) && $value > 0 ) {
            $value = floor( $value * 100 ); // Set the amount in cents.
    		$this->data['amount'] = $value;
    	} else {
    		$this->data['amount'] = 0;
    	}
    }
    /*
     * Set first name
     */
    private function setFirstName()
    {
    	if ( empty($_POST['first_name'] ) ) {
    		$this->data['error']['first_name'] = "Please provide your first name.";
            $this->error = true;
            return;
        }
    
        $fn = trim( $_POST['first_name'] );
    
		if ( preg_match('/^[A-Z \'.-]{1,40}$/i', $fn ) ) {
			$this->data['first_name'] = $fn;
		} else {
			$this->data['error']['first_name'] = "Your first name can include letters, apostrophes, periods and hyphens.";
            $this->error = true;
		}
    }
    /*
     * Set last name
     */
    private function setLastName()
    {
    	if ( empty($_POST['last_name'] ) ) {
    		$this->data['error']['last_name'] = "Please provide your last name.";
            $this->error = true;
            return;
        }
    
        $ln = trim( $_POST['last_name'] );
    
    	if (preg_match('/^[A-Z \'.-]{1,40}$/i', $ln)) {
			$this->data['last_name'] = $ln;
		} else {
			$this->data['error']['last_name'] = "Your last name can include letters, apostrophes, periods and hyphens.";
            $this->error = true;
		}
    }
    /*
     * Set address
     */
    private function setAddress()
    {
    	if ( empty($_POST['address'] ) ) {
    		$this->data['error']['address'] = "Please provide your street address.";
            $this->error = true;
            return;
        }
    
        $a = trim( $_POST['address'] );
    
		if ( preg_match('/^[A-Z0-9 \',.#-]{1,160}$/i', $a ) ) {
			$this->data['address'] = $a;
		} else {
    		$this->data['error']['address'] = "Please provide your street address.";
            $this->error = true;
		}
    }
    /*
     * Set city
     */
    private function setCity()
    {
    	if ( empty($_POST['city'] ) ) {
    		$this->data['error']['city'] = "Please provide your city.";
            $this->error = true;
            return;
    	}
    
        $c = trim( $_POST['city'] );
    
		if (preg_match('/^[A-Z \'.-]{1,60}$/i', $c ) ) {
			$this->data['city'] = $c;
		} else {
    		$this->data['error']['city'] = "Please provide your city.";
            $this->error = true;
		}
    }
    /*
     * Set region (province or state)
     */
    private function setRegion()
    {
        if ( ! isset( $this->data['country'] ) ) {
            return;
        }
    
        if ( ! isset( $_POST['region'] ) ) {
            $this->data['error']['region'] = "Please provide your province or state.";
            $this->error = true;
            return;
        }
    
        $r = trim( $_POST['region'] );
    
        if ( $this->data['country'] == 'CA' ) {
            $regions = $this->regions->get('provinces');
            if ( ! array_key_exists($r, $regions ) ) {
                $this->data['error']['region'] = "Please select your province.";
                $this->error = true;
                return;
            }
        }
        elseif ( $this->data['country'] == 'US' ) {
            $regions = $this->regions->get('states');
            if ( ! array_key_exists($r, $regions ) ) {
                $this->data['error']['region'] = "Please select your state.";
                $this->error = true;
                return;
            }
        }
    
        $this->data['region'] = $r;
    }
    /*
     * Set country
     */
    private function setCountry()
    {
    	if ( empty( $_POST['country'] ) ) {
            $this->data['error']['country'] = 'Please select your country.';
            $this->error = true;
            return;
        }
    
        $c = trim( $_POST['country'] );
    
        if ( $c != 'CA' && $c != 'US' ) {
            $this->data['error']['country'] = 'Please select your country.';
            $this->error = true;
            return;
        }
    
        $this->data['country'] = $c;
    }
    /*
     * Set postal code (or zip code)
     */
    private function setPostalCode()
    {
    	if ( ! isset( $_POST['postal_code'] ) ) {
    		$this->data['error']['postal_code'] = 'Please provide your postal or zip code.';
            $this->error = true;
            return;
        }
    
        $pc = trim( $_POST['postal_code'] );
	
    
        // Make sure the country is set
        if ( ! isset( $this->data['country'] ) ) {
            $pc_obj = new PostalCode( $pc );
            if ( $pc_obj->isValid() ) {
                $this->data['postal_code'] = $pc_obj->get();
                return;
            }
        
            $zip_obj = new ZipCode( $pc );
            if ( $zip_obj->isValid() ) {
                $this->data['postal_code'] = $zip_obj->get();
                return;
            }
        }
    
        if ( $this->data['country'] == 'CA' ) {
            $pc_obj = new PostalCode( $pc );
            if ( ! $pc_obj->isValid() ) {
				$this->data['error']['postal_code'] = 'Please provide a valid postal code.';
                $this->error = true;
                return;
            }
            $this->data['postal_code'] = $pc_obj->get();
        }
        elseif ( $this->data['country'] == 'US' ) {
            $zip_obj = new ZipCode( $pc );
            if ( ! $zip_obj->isValid() ) {
				$this->data['error']['postal_code'] = 'Please provide a valid zip code.';
                $this->error = true;
                return;
            }
            $this->data['postal_code'] = $zip_obj->get();
        }
    }
    /*
     * Set telephone number
     */
    private function setTelephone()
    {
    	if ( empty($_POST['telephone'] ) ) {
            $this->data['error']['telephone'] = 'Please provide a valid phone number.';
            $this->error = true;
            return;
        }
	
        $t = trim( $_POST['telephone'] );
    
		// Remove non-digits.
		$t = preg_replace('/[^0-9]/', '', $t);
	
		// Make sure it's 10 digits.
		if ( strlen($t) != 10 ) {
			$this->data['error']['telephone'] = 'Please provide a valid phone number.';
            $this->error = true;
            return;
		}
	
        $this->data['telephone'] = $t;
    }
    /*
     * Set email address
     */
    private function setEmail()
    {
	    if ( empty( $_POST['email'] ) ) {
			$this->data['error']['email'] = 'Please provide a valid email address.';
            $this->error = true;
            return;
        }
    
        $e = trim( $_POST['email'] );
    
		if ( ! filter_var( $e, FILTER_VALIDATE_EMAIL ) ) {
			$this->data['error']['email'] = 'Please provide a valid email address.';
            $this->error = true;
            return;
		}
    
		$this->data['email'] = $e;
    }

    
    /*
     * Set the session id
     */
    protected function setAnonymity()
    {
    	if ( isset( $_POST['anonymity'] ) && ! empty( $_POST['anonymity'] ) ) {
    		$this->data['anonymity'] = 1;
    	} else {
    		$this->data['anonymity'] = 0;
    	}
    }
    
    /*
     * Set the session id
     */
    protected function setHideAmount()
    {
    	if (isset($_POST['hide_amount']) && !empty($_POST['hide_amount'])) {
    		$this->data['hide_amount'] = 1;
    	} else {
    		$this->data['hide_amount'] = 0;
    	}
    }
    
    /*
     * Add the payment data from a successful payment to the database
     */
    private function addPaymentToDatabase()
    {
        $this->setReceiptKey();
    
        $this->createDonorEntry();
        $this->createDonationEntry();
        $this->createDonationContentEntry();
        $this->createDonorAddressEntry();
        $this->addDonationToFundraisersTotalRaise();
    
        $this->redirect('donations');
    }
    
    /*
     * Generate a receipt key
     */
    protected function setReceiptKey()
    {
	    $random = rand(1, 1000) + time() + 'RH6N#gY5GP$l4D#(_4x.bn:=jw2H7L';
	    for ($i = 0; $i < 50; $i += 1) {
	        $random = hash ('sha1', $random, FALSE);
	    }
	    $this->receipt_key = $random;
    }
    
    /*
     * Add entry to donors table
     */
    protected function createDonorEntry()
    {
        $this->donor = new Donor;
        
        $this->donor->set('email', $this->data['email']);
        $this->donor->set('first_name', $this->data['first_name']);
        $this->donor->set('last_name', $this->data['last_name']);
        $this->donor->set('anonymity', $this->data['anonymity'] );
        $this->donor->set('hide_amount', $this->data['hide_amount'] );
        $this->donor->set('receipt_key', $this->receipt_key);
        
        $this->donor->create();
    }

    /*
     * Add entry to donations table
     */
    protected function createDonationEntry()
    {
        $this->donation = new Donation;
        
        $this->donation->set('donor_id', $this->donor->get('id'));
        $this->donation->set('fundraiser_id', $this->fundraiser_profile->get('user_id'));
        $this->donation->set('amount', $this->data['amount']);
        
        $this->donation->create();
    }

    /*
     * Add entry to donation contents table
     */
    protected function createDonationContentEntry()
    {
        $this->donation_content = new DonationContent;
        
        $this->donation_content->set('donation_id', $this->donation->get('id'));
        $this->donation_content->set('donation_per_hole', 0);
        $this->donation_content->set('donation_flat_amount', $this->data['amount'] );
        $this->donation_content->set('sponsored_holes', $this->fundraiser_profile->get('goal_holes'));
        
        $this->donation_content->create();
    }

    /*
     * Add entry to donor addresses table
     */
    protected function createDonorAddressEntry()
    {
        $this->donor_address = new DonorAddress;
        
        $this->donor_address->set('donor_id', $this->donor->get('id'));
        $this->donor_address->set('address', $this->data['address']);
        $this->donor_address->set('city', $this->data['city']);
        $this->donor_address->set('region', $this->data['region']);
        $this->donor_address->set('country', $this->data['country']);
        $this->donor_address->set('postal_code', $this->data['postal_code']);
        $this->donor_address->set('telephone', $this->data['telephone']);
        
        $this->donor_address->create();
    }

    /*
     * Add the donation amount to the fundraiser's current raise amount
     */
    protected function addDonationToFundraisersTotalRaise()
    {
        $this->fundraiser_profile->addDonation( $this->data['amount'] );
        $this->fundraiser_profile->update();
    }
}
