<?php
namespace Src\App;

require 'Initialize.php';

use Src\App\SSLLayer;

class AppController
{
    public $init;
    protected $app_model;
    private $ssl_layer;
    
    /*
     * Store the module controller
     */
    private $module;
    
    /*
     * Constructor
     */
    public function __construct()
    {
        $this->init = new Initialize;
        $this->run();
    }
    
    /*
     * Run
     */
    private function run()
    {
        $this->setModuleName();
        $this->checkSSL();
        $this->setModule();
        
        $this->module->run();
    }
    
    /*
     * Set the module name
     */
    private function setModuleName()
    {
        $this->app_model = new AppModel();
        $this->module_name = $this->app_model->getModule();
    }
    
    /*
     * Get the module
     */
    private function setModule()
    {
        $class = 'Src\Modules\\' . $this->module_name . '\Controller';
        $this->module = new $class;
        $this->module->setModuleName( $this->module_name );
        $this->module->setMap( $this->app_model->getMap() );
    }
    
    /*
     * Check for SSL
     */
    private function checkSSL()
    {
        $this->ssl_layer = new SSLLayer();
        $this->ssl_layer->setModuleName( $this->module_name );
        $this->ssl_layer->run();
    }
}