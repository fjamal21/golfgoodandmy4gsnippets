<?php
namespace Src\Modules\Prizes;

use Src\Includes\SuperClasses\AbstractContentController;
use Src\Includes\Prize;

class Controller extends AbstractContentController
{
    /*
     * Set the content type
     */
    protected function setContentType()
    {
        $this->content_type = 'Prize';
    }
}
