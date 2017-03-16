<?php
namespace Src\Modules\Pages\Views;

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
			<label for="tagline">Tagline<br /><span class="form-help-text">This will appear below the page title. Max: 255 characters</span></label>
			<textarea name="tagline" id="tagline" rows="2">';
	
	    if ( $this->content->getMeta('tagline') ) echo htmlspecialchars( $this->content->getMeta('tagline') );
	    echo '</textarea>
		</div>
	    ';
    }
}
