<?php
namespace Src\Modules\Charities\Models;

use Src\Includes\SuperClasses\AbstractContentActionModel;
use Src\Includes\Tagline;
use Src\Includes\Image;
use Src\Includes\Video;
use Src\Includes\VideoDescription;
use Src\Includes\SelectableCharity;
use Src\Includes\Rank;
use Src\Includes\Url;

class AddModel extends AbstractContentActionModel
{
    /*
     * Content objects
     */
    protected $tagline;
    protected $image_secondary;
    protected $video;
    protected $video_description;
    protected $selectable;
    protected $rank;
    protected $url;
    
    /*
     * Set submitted meta content
     */
    protected function setSubmittedMeta()
    {
        $this->setDataObject( new Tagline, 'tagline' );
        $this->content_obj->setMeta( 'tagline', $this->tagline->get() );
        
        $this->setImage( new Image, 'image_secondary' );
        if ( $this->image_secondary->get('file_name') ) {
            $this->content_obj->setMeta('image_secondary', $this->image_secondary->getFullName() );
            $this->processImage( 'image_secondary' );
        }
        
        $this->setDataObject( new Video, 'video' );
        $this->content_obj->setMeta( 'video', $this->video->get() );
        
        $this->setDataObject( new VideoDescription, 'video_description' );
        $this->content_obj->setMeta( 'video_description', $this->video_description->get() );
        
        $this->setDataObject( new SelectableCharity, 'selectable' );
        $this->content_obj->setMeta( 'selectable', $this->selectable->get() );
        
        $this->setDataObject( new Rank, 'rank' );
        $this->content_obj->setMeta( 'rank', $this->rank->get() );
        
        $this->setDataObject( new Url, 'url' );
        $this->content_obj->setMeta( 'url', $this->url->get() );
    }
}
