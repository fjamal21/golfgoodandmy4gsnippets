<?php
namespace Src\Includes;

/*
 * Password class
 *
 * Holds password rules
 */

class Password
{
    /*
     * Hashing algorithm
     */
    private $algorithm = PASSWORD_DEFAULT;
    private $cost;
    
	/*
	 * Store the value
	 */
	private $value = null;
	
	/*
	 * Store the validity
	 */
	private $valid = true;
	private $error = null;
	
	/*
	 * Constructor
	 */
	public function __construct( $value = null )
	{
		$this->value = trim($value);
	}
	
	/*
	 * Test the value
	 */
	public function test()
	{
		// Check if it passes username character rules
		if ( !$this->isValid() ) {
			return false;
		}
		
		// It's OK
		return true;
	}
	
	/*
	 * Check if the name is valid
	 */
	public function isValid()
	{
		// Make sure it's not empty
		if ( !$this->value ) {
			$this->valid = false;
			$this->error = 'You must enter a password.';
			return false;
		}
		
		// Must be less than 30 characters
		if ( strlen( $this->value ) < 6 ) {
			$this->valid = false;
			$this->error = 'Your password must be at least 6 characters.';
			return false;
		}
		
		// It's valid
		return true;
	}
	
	/*
	 * Return the value
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/*
	 * Return the error
	 */
	public function getError()
	{
		return $this->error;
	}
    
    /*
     * Hash the password
     */
    public function getHash()
    {
        return password_hash( $this->value, $this->algorithm );
    }
}