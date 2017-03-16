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
        'login' => 'Login',
        'forgotpassword' => 'Login',
        'resetpassword' => 'Login',
        'logout' => 'Logout',
        'settings' => 'Settings',
        'users' => 'Users',
        'pages' => 'Pages',
        'blog' => 'Blog',
        'prizes' => 'Prizes',
        'charities' => 'Charities',
        'donations' => 'Donations'
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
            $this->map['guid'] = strtolower( $default );
            return $default;
        }
        
        $this->map['guid'] = strtolower( trim( $_GET['guid'] ) );
        
        if ( array_key_exists( $this->map['guid'], $this->modules ) ) {
            $this->map['module'] = $this->modules[ $this->map['guid'] ];
        }
        else {
            $this->map['module'] = 'NotFound';
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
    
    /*
     * Redirect
     */
    
}
