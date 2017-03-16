<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractDataValue;

class PostalCode extends AbstractDataValue
{
    /*
     * Validate
     */
    public function isValid()
    {
		$this->value = strtoupper($this->value);

		if ( preg_match('/^[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} *\d{1}[A-Z]{1}\d{1}$/i', $this->value ) ) {
			return true;
		}
        
        return false;
    }
}
