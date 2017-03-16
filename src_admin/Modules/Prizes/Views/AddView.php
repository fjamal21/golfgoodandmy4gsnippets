<?php
namespace Src\Modules\Prizes\Views;

use Src\Includes\SuperClasses\AbstractContentForm;

class AddView extends AbstractContentForm
{
    /*
     * Function to display the meta data form sections
     */
    protected function displayMeta()
    {
        // Override to add meta form here
        echo '
		<div>
			<label for="prize_name">Prize Name<br /><span class="form-help-text">e.g. Grand Prize, 2nd Place, etc. Max: 100 characters</span></label>
			<input type="text" name="prize_name" id="prize_name"';
	
	if ( $this->content->getMeta('prize_name') ) echo ' value="' . htmlspecialchars( $this->content->get('prize_name') ) . '"';
	echo ' />
		</div>
	    ';


        echo '
		<div>
			<label for="display_order">Display Order<br /><span class="form-help-text">Defines a sort order. 0 values are last.</span></label>
			<input type="text" name="display_order" id="display_order"';
	
	if ( $this->content->getMeta('display_order') ) echo ' value="' . htmlspecialchars( $this->content->get('display_order') ) . '"';
	echo ' />
		</div>
	    ';


        echo '
		<div>
			<label for="quantity">Quantity Available<br /><span class="form-help-text">The number available to be won. Leave empty for infinite</span></label>
			<input type="text" name="quantity" id="quantity"';
	
	if ( $this->content->getMeta('quantity') ) echo ' value="' . htmlspecialchars( $this->content->get('quantity') ) . '"';
	echo ' />
		</div>
	    ';


        echo '
		<div>
			<label for="minimum_raise">Minimum Raise<br /><span class="form-help-text">The lowest dollar amount required to receive this prize</span></label>
			<input type="text" name="minimum_raise" id="minimum_raise"';
	
	if ( $this->content->getMeta('minimum_raise') ) echo ' value="' . htmlspecialchars( $this->content->getMeta('minimum_raise') ) . '"';
	echo ' />
		</div>
	    ';


        echo '
		<div>
			<label for="retail_value">Retail Value<br /><span class="form-help-text">The value of this prize as a dollar amount</span></label>
			<input type="text" name="retail_value" id="retail_value"';
	
	if ( $this->content->getMeta('retail_value') ) echo ' value="' . htmlspecialchars( $this->content->getMeta('retail_value') ) . '"';
	echo ' />
		</div>
	    ';
    }
}
