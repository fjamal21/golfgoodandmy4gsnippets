<?php
namespace Src\Includes;

use Src\Includes\DB;

class EmailSubscription
{
    /*
     * Data
     */
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $date_added;
    private $date_modified;
    
    /*
     * Constructor. Set null values
     */
    public function construct()
    {
        $this->id = null;
        $this->email = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->date_added = null;
        $this->date_modified = null;
    }
    /*
     * Set a value
     */
    public function set( $key, $value = null )
    {
        $this->$key = $value;
    }
    
    /*
     * Get a value
     */
    public function get( $key )
    {
        if ( $this->$key != null ) {
            return $this->$key;
        }
        return null;
    }
    
    /*
     * Create
     */
    public function create()
    {
        if ( ! $this->email || ! $this->first_name || ! $this->last_name ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO email_subscribers (
            email,
            first_name,
            last_name,
            date_added
        ) VALUES (
            :email,
            :first_name,
            :last_name,
            CURRENT_TIMESTAMP()
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':email', $this->email);
        $sh->bindParam(':first_name', $this->first_name);
        $sh->bindParam(':last_name', $this->last_name);
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
        
    }
    
    /*
     * Read
     */
    public function read()
    {
        if ( ! $this->email ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT * FROM email_subscribers WHERE email=:email LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':email', $this->email);
        $sh->execute();
        
        $r = array();
        if ( $sh->rowCount() == 1 ) {
            $r = $sh->fetch(\PDO::FETCH_ASSOC);
        }
        if ( ! empty( $r ) ) {
            foreach ( $r as $k => $v ) {
                $this->$k = $v;
                //echo $k . ' => ' . $v . '<br />';
            }
            return true;
        }
        return false;
    }
    
    /*
     * Update
     */
    public function update()
    {
        if ( ! $this->id || ! $this->email || ! $this->first_name || ! $this->last_name ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE email_subscribers SET email=:email, first_name=:first_name, last_name=:last_name WHERE id=:id LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':email', $this->email);
        $sh->bindParam(':first_name', $this->first_name);
        $sh->bindParam(':last_name', $this->last_name);
        $sh->bindParam(':id', $this->id);
        
        if ( $sh->execute() ) {
            return true;
        }
        return false;
    }
    
    /*
     * Delete
     */
    public function delete()
    {
        if ( ! $this->id || ! $this->email ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "DELETE FROM email_subscribers WHERE id=:id OR email=:email LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':id', $this->id);
        $sh->bindParam(':email', $this->email);
        
        if ( $sh->execute() ) {
            $this->id = null;
            $this->email = null;
            $this->first_name = null;
            $this->last_name = null;
            return true;
        }
        return false;
    }
    
    /*
     * Check if a user is subscribed
     */
    public function isSubscribed()
    {
        if ( ! $this->id ) {
            return false;
        }
        return true;
    }
}
