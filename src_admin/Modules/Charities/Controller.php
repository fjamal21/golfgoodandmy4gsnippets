<?php
namespace Src\Modules\Charities;

use Src\Includes\SuperClasses\AbstractContentController;
use Src\Includes\Charity;

class Controller extends AbstractContentController
{
    /*
     * Set the content type
     */
    protected function setContentType()
    {
        $this->content_type = 'Charity';
    }
}
