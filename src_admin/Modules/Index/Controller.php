<?php
namespace Src\Modules\Index;

use Src\Includes\SuperClasses\AbstractController;
use Src\Config\Config;
use Src\Includes\DB;
use Src\Includes\User;
use Src\Modules\Login\Controller as Login;

class Controller extends AbstractController
{   
    public function run()
    {
        $user = User::getInstance();
        
        if ( $user->isLoggedIn() && $user->canAccessAdmin() ) {
            $this->displayIndex();
            return;
        }
        
        $this->login();
    }
    
    /*
     * The user is logged in. Display the admin index.
     */
    private function displayIndex()
    {
        $pdo = DB::getInstance();
        $config = Config::getInstance();
        $user = User::getInstance();
        
        include 'index.inc.php';
    }
    
    /*
     * The user is NOT logged in. Show and process login.
     */
    private function login()
    {
        $login = new Login;
        $login->setMap( $this->map );
        $login->run();
    }
}
