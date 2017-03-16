<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractDataValue;

class ZipCode extends AbstractDataValue
{
    /*
     * Constructor
     */
    public function __construct( $value = null )
    {
        $this->value = $value;
        $this->sanitize();
    }
    
    /*
     * Validate
     */
    public function isValid()
    {
		if ( preg_match('/^(\d{5}$)|(^\d{5}-?\d{4})$/', $this->value ) ) {
			return true;
		}
        
        return false;
    }
    
    /*
     * Sanitize
     */
    public function sanitize()
    {
        $this->value = trim( $this->value );
        $this->value = preg_replace( '/[^0-9]/', '', $this->value );
        if ( strlen( $this->value ) > 9 ) {
            $this->value = substr( $this->value, 0, 6 );
        }
    }
    
    /*
     * Get formatted postal code
     */
    public function getFormatted()
    {
        $value = $this->value;
        if ( strlen( $value ) > 5 ) {
            $start = substr( $value, 0, 5 );
            $end = substr( $value, 5 );
            $value = $start . '-' . $end;
        }
        return $value;
    }
}
