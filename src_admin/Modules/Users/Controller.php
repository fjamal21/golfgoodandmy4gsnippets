<?php
namespace Src\Modules\Users;

use Src\Includes\SuperClasses\AbstractController;

class Controller extends AbstractController
{
    /*
     * Run
     */
    public function run()
    {
        $this->setClass();
        $this->setModel();
        $this->setView();
    }
    
    /*
     * Set the class
     */
    protected function setClass()
    {
        $default = 'List';
        if ( isset( $_GET['spid'] ) ) {
            switch ( $_GET['spid'] ) {
                case 'fundraisers':
                    $this->class = 'Fundraisers';
                    return;
                default:
                    $this->class = $default;
                    return;
            }
        }
        $this->class = $default;
    }
    
    /*
     * Set the class
     */
    protected function setModel()
    {
        $class = 'Src\Modules\\' . $this->module_name . '\Models\\' . $this->class . 'Model';
        $this->model = new $class;
        $this->model->setModuleName( $this->module_name );
        $this->model->run();
    }
    
    /*
     * Set the class
     */
    protected function setView()
    {
        $view = 'Src\Modules\\' . $this->module_name . '\Views\\' . $this->class . 'View';
        $this->view = new $view;
        
        $this->view->setData( $this->model->getData() );
        
        $this->view->run();
    }
}