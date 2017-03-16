<?php
namespace Src\Includes;

use Src\Config\Config;
use Src\Includes\RandomHash;
use Src\Includes\Traits\tUniqueDatabaseValue;

class Username
{
    use tUniqueDatabaseValue;
    
    /*
     * Store the random hash object
     */
    private $random_hash = null;
    
    /*
     * Store the value
     */
    protected $value;
    
    /*
     * Get
     */
    public function get()
    {
        return $this->value;
    }
    
    /*
     * Create a unique directory
     */
    public function create()
    {
        $this->createUniqueUsername();
    }
    
    /*
     * Set the value
     */
    private function createUniqueUsername()
    {
        if ( ! $this->random_hash ) {
            $this->random_hash = new RandomHash;
            $this->random_hash->setLength(8);
        }
        
        $unique = false;
        
        while ( ! $unique ) {
            $this->random_hash->generate();
            $this->value = $this->random_hash->get();
            if ( $this->isUnique( 'users', 'username', $this->value ) ) {
                $unique = true;
            }
        }
    }
}
