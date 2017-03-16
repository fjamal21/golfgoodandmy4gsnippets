<?php
namespace Src\Modules\Charities;

use Src\Includes\SuperClasses\AbstractDirectoryController;

class Controller extends AbstractDirectoryController
{
    /*
     * Set the content type
     */
    protected function setContentType()
    {
        $this->content_type = 'Charity';
    }
}
