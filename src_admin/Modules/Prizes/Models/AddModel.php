<?php
namespace Src\Modules\Prizes\Models;

use Src\Includes\SuperClasses\AbstractContentActionModel;
use Src\Includes\PrizeName;
use Src\Includes\DisplayOrder;
use Src\Includes\Quantity;
use Src\Includes\Currency;

class AddModel extends AbstractContentActionModel
{
    /*
     * Content objects
     */
    protected $prize_name;
    protected $display_order;
    protected $quantity;
    protected $minimum_raise;
    protected $retail_value;
    
    /*
     * Set submitted meta content
     */
    protected function setSubmittedMeta()
    {
        $this->setDataObject( new PrizeName, 'prize_name' );
        $this->content_obj->setMeta( 'prize_name', $this->prize_name->get() );
        
        $this->setDataObject( new DisplayOrder, 'display_order' );
        $this->content_obj->setMeta( 'display_order', $this->display_order->get() );
        
        $this->setDataObject( new Quantity, 'quantity' );
        $this->content_obj->setMeta( 'quantity', $this->quantity->get() );
        
        $this->setDataObject( new Currency, 'minimum_raise' );
        $this->content_obj->setMeta( 'minimum_raise', $this->minimum_raise->get() );
        
        $this->setDataObject( new Currency, 'retail_value' );
        $this->content_obj->setMeta( 'retail_value', $this->retail_value->get() );
    }
}
