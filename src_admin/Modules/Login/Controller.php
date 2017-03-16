<?php
namespace Src\Modules\Login;

use Src\Includes\SuperClasses\AbstractController;
use Src\Config\Config;
use Src\Includes\DB;
use Src\Includes\Session;
use Src\Includes\User;

class Controller extends AbstractController
{
    /*
     * Subpage to include
     */
    private $subpage;
    
    public function run()
    {
        $this->setSubPage();
        $this->redirectIfLoggedIn();

        $config = Config::getInstance();
        $pdo = DB::getInstance();
        $session = Session::getInstance();
        $user = User::getInstance();

        include $this->subpage;
    }
    
    /*
     * Redirect if logged in
     */
    private function redirectIfLoggedIn()
    {
        if ( $this->map['guid'] == 'login' || $this->map['guid'] == 'forgotpassword' ) {
            $user = User::getInstance();
            if ( $user->isLoggedIn() ) {
                header('Location: /index');
                exit;
            }
        }
    }
    
    /*
     * Determine which page to display
     */
    private function setSubPage()
    {
        switch ($this->map['guid']) {
        	case 'forgotpassword':
        		$this->subpage = 'forgot-password.inc.php';
        		break;
        	case 'resetpassword':
        		$this->subpage = 'reset-password.inc.php';
        		break;
            case 'login':
        	default:
                $this->map['guid'] = 'login';
        		$this->subpage = 'login.inc.php';
        		break;
        }
    }
}