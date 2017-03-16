<?php
namespace Src\Modules\Blog;

use Src\Includes\SuperClasses\AbstractContentController;

class Controller extends AbstractContentController
{
    /*
     * Set the content type
     */
    protected function setContentType()
    {
        $this->content_type = 'BlogPost';
    }
}