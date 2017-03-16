<?php
namespace Src\Includes;

use Src\Includes\SuperClasses\AbstractContentMeta;
use Src\Includes\DB;

class PrizesMeta extends AbstractContentMeta
{
    /*
     * Data
     */
    protected $meta_name = 'prizes';
    protected $prize_name;
    protected $display_order;
    protected $quantity;
    protected $minimum_raise;
    protected $retail_value;
    
    /*
     * Construct
     */
    public function __construct()
    {
        $this->prize_name = null;
        $this->display_order = null;
        $this->quantity = null;
        $this->minimum_raise = null;
        $this->retail_value = null;
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
        
        $q = "INSERT INTO prizes_meta (
            content_id,
            prize_name,
            display_order,
            quantity,
            minimum_raise,
            retail_value
        ) VALUES (
            :content_id,
            :prize_name,
            :display_order,
            :quantity,
            :minimum_raise,
            :retail_value
        )";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':content_id', $this->content_id);
        $sh->bindParam(':prize_name', $this->prize_name);
        $sh->bindParam(':display_order', $this->display_order);
        $sh->bindParam(':quantity', $this->quantity);
        $sh->bindParam(':minimum_raise', $this->minimum_raise);
        $sh->bindParam(':retail_value', $this->retail_value);
        
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
        
        $q = "UPDATE prizes_meta SET
            prize_name=:prize_name,
            display_order=:display_order,
            quantity=:quantity,
            minimum_raise=:minimum_raise,
            retail_value=:retail_value
        WHERE content_id=:content_id";
        
        $sh = $pdo->prepare($q);
        $sh->bindParam(':prize_name', $this->prize_name);
        $sh->bindParam(':display_order', $this->display_order);
        $sh->bindParam(':quantity', $this->quantity);
        $sh->bindParam(':minimum_raise', $this->minimum_raise);
        $sh->bindParam(':retail_value', $this->retail_value);
        $sh->bindParam(':content_id', $this->content_id);
        
        $sh->execute();
        
        if ( $sh->rowCount() == 1 ) {
            return true;
        }
        return false;
    }
}
