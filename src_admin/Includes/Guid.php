<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractCrud;
use Src\Includes\DB;

class Guid extends AbstractCrud
{
    /*
     * Store values
     */
    protected $id;
    protected $guid;
    protected $module;
    protected $content_id;
    protected $date_added;
    protected $date_modified;
    
    /*
     * Constructor
     */
    public function __construct( $guid = null )
    {
        $this->guid = $guid;
    }
    
    /*
     * Setter
     */
    public function set( $key, $value = null )
    {
        $this->$key = $value;
    }
    
    /*
     * Getter
     */
    public function get( $key )
    {
        if ( $this->$key ) {
            return $this->$key;
        }
        return null;
    }
    
    /*
     * Check if a guid exists
     */
    public function isUnique( $guid = null )
    {
        if ( ! $guid || ! $this->guid ) {
            return null;
        }
        
        if ( ! $guid ) {
            $guid = $this->guid;
        }
        
        $pdo = DB::getInstance();
        
        $q = "SELECT id FROM guids WHERE guid=:guid";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':guid', $guid);
        $sh->execute();
        
        if ( $sh->rowCount() == 0 ) {
            return true;
        }
        
        $r = $sh->fetch(\PDO::FETCH_ASSOC);
        
        if ( $this->id == $r['id'] ) {
            return true;
        }
        
        return false;
    }
    
    /*
     * Sanitize
     */
    public function sanitize()
    {
        $guid = trim( $this->guid );
        $guid = strtolower( $guid );
        $guid = preg_replace( '/[^a-z0-9 -]/', '', $guid );
        $guid = str_replace( ' ', '-', $guid );
        $guid = preg_replace( '/[-]+/' ,'-', $guid );
        $this->guid = $guid;
    }
    
    /*
     * Create
     */
    public function create()
    {
        if ( ! $this->guid || ! $this->module || ! $this->content_id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "INSERT INTO guids (
            guid,
            module,
            content_id,
            date_added
        ) VALUES (
            :guid,
            :module,
            :content_id,
            CURRENT_TIMESTAMP()
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':guid', $this->guid);
        $sh->bindParam(':module', $this->module);
        $sh->bindParam(':content_id', $this->content_id);
        
        if ( $sh->execute() ) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }
    
    /*
     * Read
     */
    public function read()
    {
        if ( ! $this->guid && ! $this->id && ! ( $this->content_id && $this->module ) ) {
            return false;
        }

        $pdo = DB::getInstance();
        
        if ( $this->guid ) {
            $q = "SELECT * FROM guids WHERE guid=:guid LIMIT 1";
        
            $sh = $pdo->prepare($q);
            $sh->bindParam(':guid', $this->guid);
        }
        elseif ( $this->id ) {
            $q = "SELECT * FROM guids WHERE id=:id LIMIT 1";
        
            $sh = $pdo->prepare($q);
            $sh->bindParam(':id', $this->id);
        }
        else {
            $q = "SELECT * FROM guids WHERE content_id=:content_id AND module=:module LIMIT 1";
        
            $sh = $pdo->prepare($q);
            $sh->bindParam(':content_id', $this->content_id);
            $sh->bindParam(':module', $this->module);
        }
        
        $sh->execute();
        
        if ( ! $sh->execute() ) {
            return false;
        }
        $this->original = $sh->fetch(\PDO::FETCH_ASSOC);
        if ( ! $this->original ) {
            $this->original = array();
            return false;
        }
        foreach ( $this->original as $k => $v ) {
            $this->$k = $v;
        }
        return true;
    }
    
    /*
     * Update
     */
    public function update()
    {
        if ( ! $this->id || ! $this->guid ) {
            return false;
        }
        
        if ( ! $this->hasChanged() ) {
            return true;
        }
        
        $pdo = DB::getInstance();
        
        $q = "UPDATE guids SET guid=:guid WHERE id=:id LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':guid', $this->guid);
        $sh->bindParam(':id', $this->id);
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            return true;
        }
        return false;
    }
    
    /*
     * Delete
     */
    public function delete()
    {
        if ( ! $this->id ) {
            return false;
        }
        
        $pdo = DB::getInstance();
        
        $q = "DELETE FROM guids WHERE id=:id LIMIT 1";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':id', $this->id);
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            return true;
        }
        return false;
    }
}
