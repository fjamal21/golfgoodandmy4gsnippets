<?php
namespace Src\Includes;

use Src\Includes\DB;

class Prizes
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
        
        $q = "SELECT g.guid, c.*, pm.*, u.email
            FROM prizes_meta AS pm
            LEFT JOIN guids AS g ON g.content_id=pm.content_id
            LEFT JOIN content AS c ON c.id=g.content_id
            LEFT JOIN users AS u ON c.author_id=u.id
            WHERE g.module='prizes'
            ORDER BY pm.display_order ASC";
        
        $sh = $pdo->prepare($q);
        
        if ( ! $sh->execute() ) {
            return false;
        }
        $this->array = $sh->fetchAll(\PDO::FETCH_ASSOC);
    }
}
