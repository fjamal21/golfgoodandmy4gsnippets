<?php
namespace Src\Modules\Donations;

use Src\Includes\SuperClasses\AbstractController;
use Src\Config\Config;
use Src\Includes\DB;
use Src\Includes\User;
use Src\Includes\Donations;

class Controller extends AbstractController
{
    /*
     * Run
     */
    public function run()
    {
        $user = User::getInstance();
        
        if ( ! $user->isLoggedIn() ) {
            $this->redirect('login');
        }
        
        $this->setClass();
        $this->setModel();
        $this->setView();
    }
    
    /*
     * Set the class
     */
    protected function setClass()
    {
        if ( ! isset( $_GET['action'] ) ) {
            $this->class = 'List';
            return;
        }
        
        $action = trim( $_GET['action'] );
        
        switch ( $action ) {
            case 'add':
                $class = 'Add';
                break;
            default:
                $class = 'List';
                break;
        }
        
        $this->class = $class;
    }
    
    /*
     * Set the model
     */
    protected function setModel()
    {
        $class = 'Src\Modules\\' . $this->module_name . '\Models\\' . $this->class . 'Model';
        
        $this->model = new $class;
        $this->model->run();
    }
    
    /*
     * Set the view
     */
    protected function setView()
    {
        $class = 'Src\Modules\\' . $this->module_name . '\Views\\' . $this->class . 'View';
        
        $this->view = new $class;
        $this->view->setData( $this->model->getData() );
        $this->view->run();
    }
}
