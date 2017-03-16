<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractContentMeta;
use Src\Includes\DB;

class PagesMeta extends AbstractContentMeta
{
    /*
     * Data
     */
    protected $tagline;
    protected $meta_name = 'pages';
    
    /*
     * Construct
     */
    public function __construct()
    {
        $this->tagline = null;
    }
    
    /*
     * Create
     */
    public function create()
    {
        if ( ! $this->content_id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO pages_meta (
            content_id,
            tagline
        ) VALUES (
            :content_id,
            :tagline
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':content_id', $this->content_id);
        $sh->bindParam(':tagline', $this->tagline);
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            return true;
        }
        return false;
    }
    
    /*
     * Update
     */
    public function update()
    {
        if ( ! $this->content_id ) {
            return false;
        }
        
        if ( ! $this->hasChanged() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE pages_meta SET tagline=:tagline WHERE content_id=:content_id";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':tagline', $this->tagline);
        $sh->bindParam(':content_id', $this->content_id);
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            return true;
        }
        return false;
    }
}
