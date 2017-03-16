<?php
namespace Src\Modules\Pages\Models;

use Src\Includes\SuperClasses\AbstractContentActionModel;
use Src\Includes\Tagline;

class EditModel extends AbstractContentActionModel
{
    /*
     * Content object
     */
    protected $tagline;
    
    /*
     * Set submitted meta content
     */
    protected function setSubmittedMeta()
    {
        $this->setDataObject( new Tagline, 'tagline' );
        $this->content_obj->setMeta( 'tagline', $this->tagline->get() );
    }
}
