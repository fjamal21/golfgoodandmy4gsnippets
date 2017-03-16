<?php
namespace Src\Modules\Donations\Models;

use Src\Includes\SuperClasses\AbstractModel;
use Src\Includes\Donations;

class ListModel extends AbstractModel
{
    /*
     * Objects
     */
    protected $donations;
    /*
     * Run
     */
    public function run()
    {
        $this->setDonations();
    }
    
    /*
     * Set donations
     */
    protected function setDonations()
    {
        $this->donations = new Donations;
        $this->donations->readAll();
        
        $this->data['donations'] = $this->donations;
    }
}
