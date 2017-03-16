<?php
namespace Src\Includes;

use Src\Includes\DB;

class UserRole
{
    /*
     * Store values
     */
    private $id = null;
    private $user_id = null;
    private $roles = array();
    private $date_modified;
    
    /*
     * Available roles
     */
    private $available_roles = array(
        'fundraiser' => 'Fundraiser',
        'advocate' => 'Advocate',
        'editor' => 'Editor',
        'auditor' => 'Auditor',
        'admin' =>'Admin'
    );
    private $default_role = 'fundraiser';
    
    /*
     * Set a user ID
     */
    public function setUserId( $user_id )
    {
        $this->user_id = $user_id;
    }
    
    /*
     * Set role
     */
    public function setRole( $role = null )
    {
        if ( array_key_exists( $role, $this->roles ) ) {
            return true;
        }
        if ( array_key_exists( $role, $this->available_roles ) ) {
            $this->roles[$role] = $this->available_roles[$role];
            return true;
        }
        return false;
    }
    
    /*
     * Create an entry for a user
     */
    public function create()
    {
        if ( ! $this->user_id ) {
            echo 'nada';
            return false;
        }
        
        if ( empty( $this->roles ) ) {
            $this->setRole($this->default_role);
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO user_role (
            user_id,
            roles
        ) VALUES (
            :user_id,
            :roles
        )";
        
        $roles = serialize($this->roles);
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':user_id', $this->user_id);
        $sh->bindParam(':roles', $roles);
        
        if ( $sh->execute() ) {
            return true;
        }
        echo 'nope';
        return false;
    }
    
    /*
     * Read roles
     */
    public function read()
    {
        if ( ! $this->user_id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT id, roles, date_modified FROM user_roles WHERE user_id=:user_id";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':user_id', $this->user_id);
        $r = null;
        if ( $sh->execute() ) {
            $r = $sh->fetch(\PDO::FETCH_ASSOC);
        }
        if ( $r ) {
            foreach ( $r as $k => $v ) {
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }
    
    /*
     * Is a role set?
     */
    public function hasRole( $role )
    {
        if ( array_key_exists( $role, $this->roles ) ) {
            return $this->roles[$role];
        }
        return false;
    }
}
