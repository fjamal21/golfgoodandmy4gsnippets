<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractDataValue;

class FirstName extends AbstractDataValue
{
    /*
     * Validate it
     */
    public function isValid()
    {
        if ( preg_match('/^[A-Z \'.-]{2,40}$/i', $this->value) ) {
            return true;
        }
        return false;
    }

    /*
     * Return a sanitized string
     */
    public function getSanitized()
    {
        return filter_var( $this->value, FILTER_SANITIZE_STRING );
    }
}
