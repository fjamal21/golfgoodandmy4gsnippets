<?php
namespace Src\Modules\Users\Models;

use Src\Includes\SuperClasses\AbstractModel;
use Src\Includes\Users;

class ListModel extends AbstractModel
{
    /*
     * Run
     */
    public function run()
    {
        $users = new Users();
        $users->read();
        $this->data['users'] = $users;
    }
}
