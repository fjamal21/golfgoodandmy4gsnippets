<?php
namespace Src\Modules\Logout;

use Src\Includes\SuperClasses\AbstractController;
use Src\Includes\Session;
use Src\Includes\User;

class Controller extends AbstractController
{
    public function run()
    {
        $session = Session::getInstance();
        $user = User::getInstance();

        if ( $user->isLoggedIn() ) {
            $session->destroy();
        }
        
        header('Location: /login');
        exit;
    }
}