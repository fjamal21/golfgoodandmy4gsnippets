<?php
namespace Src\Includes;

use Src\Includes\DB;

class Pages
{
    /*
     * Pages
     */
    protected $array = array();
    
    /*
     * Get
     */
    public function get()
    {
        return $this->array;
    }
    
    /*
     * Read
     */
    public function read()
    {
        $pdo = DB::getInstance();
        
        $q = "SELECT g.guid, c.id, c.author_id, c.title, c.status, c.date_added, c.date_modified, c.date_published, u.email
            FROM guids AS g
            LEFT JOIN content AS c ON c.id=g.content_id
            LEFT JOIN users AS u ON c.author_id=u.id
            WHERE g.module='pages'";
        
        $sh = $pdo->prepare($q);
        if ( ! $sh->execute() ) {
            return false;
            echo 'here';
        }
        $this->array = $sh->fetchAll(\PDO::FETCH_ASSOC);
    }
}
