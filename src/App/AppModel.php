<?php
namespace Src\App;

use Src\Includes\DB;

class AppModel
{
    /*
     * Define modules
     */
    private $modules = array(
        'index' => 'Index',
        'register' => 'Register',
        'activate' => 'Activate',
        'login' => 'Login',
        'forgotpassword' => 'Login',
        'resetpassword' => 'Login',
        'logout' => 'Logout',
        'settings' => 'Settings',
        'blog' => 'Blog',
        'prizes' => 'Prizes',
        'createprofile' => 'CreateProfile',
        'profile' => 'Profile',
        'donate' => 'Donate',
        'donors' => 'Donors',
        'scorecard' => 'Scorecard',
        'receipt' => 'Receipts',
//        'media' => 'Media',
//        'podcasts' => 'Podcasts',
        'charities' => 'Charities',
        'guide' =>    'Guide'
    );
    
    /*
     * guid map
     */
    private $map = array();
    
    /*
     * Check the guid
     */
    public function getModule()
    {
        $default = 'Index';
        
        if ( ! isset( $_GET['guid'] ) ) {
            $this->map['module'] = $default;
            $this->map['guid'] = $default;
            return $default;
        }
        
        $this->map['guid'] = strtolower( trim( $_GET['guid'] ) );
        
        // Check the module list
        if ( array_key_exists( $this->map['guid'], $this->modules ) ) {
            $this->map['module'] = $this->modules[$this->map['guid']];
        } else {
            
            // Check the database
            $pdo = DB::getInstance();
        
            $q = 'SELECT * FROM guids WHERE guid=:guid LIMIT 1';
        
            $sh = $pdo->prepare($q);
            $sh->bindParam(':guid', $this->map['guid']);
            if ( ! $sh->execute() ) {
                $this->map['module'] = $default;
            }
            $r = $sh->fetch(\PDO::FETCH_ASSOC);
            if ( ! $r ) {
                $this->map['module'] = $default;
            } else {
                foreach ( $r as $k => $v ) {
                    $this->map[$k] = $v;
                }
                $this->map['module'] = ucfirst($this->map['module']);
            }
        }
        
        return $this->map['module'];
    }
    
    /*
     * Return the map
     */
    public function getMap()
    {
        return $this->map;
    }
}
