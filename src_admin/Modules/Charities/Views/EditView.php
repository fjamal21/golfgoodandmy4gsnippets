<?php
namespace Src\Modules\Charities\Views;

use Src\Includes\SuperClasses\AbstractContentForm;

class EditView extends AbstractContentForm
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


    	echo '
    		<div class="form-group">
    			<label for="image_secondary" class="control-label">Secondary Image';
    	if( $this->content->getMeta('image_secondary') ) {
    		echo '<br /><span class="form-help-text">Current image: ' . $this->content->getMeta('image_secondary') . '</span>';
    	}
    	echo '</label>
    			<input type="file" name="image_secondary" id="image_secondary" />
    		</div>
    	';


    	echo '
    		<div>
    			<label for="video">Video<br /><span class="form-help-text">Add a YouTube or Vimeo video - paste in the URL of share URL</span></label>
    			<input type="url" name="video" id="video"';
		
    	if ( $this->content->getMeta('video') ) echo ' value="' . htmlspecialchars( $this->content->getMeta('video') ) . '"';
    	echo ' />
    		</div>
    	';


        echo '
		<div>
			<label for="video_description">Video Description<br /><span class="form-help-text">This will appear below the page title. Max: 500 characters</span></label>
			<textarea name="video_description" id="video_description" rows="4">';
	
	    if ( $this->content->getMeta('video_description') ) echo htmlspecialchars( $this->content->getMeta('video_description') );
	    echo '</textarea>
		</div>
	    ';


    	echo '
    		<div class="form-group"><label for="selectable" class="control-label">Can users choose to raise money for this charity?</label>
    			<select name="selectable" id="selectable" class="form-control">
    				<option value="0"';
    	if ( $this->content->getMeta('selectable') && $this->content->getMeta('selectable') == 0) echo 'selected="selected"';
    	echo '>Not selectable by any user</option>
    				<option value="1"';
    	if ( $this->content->getMeta('selectable') && $this->content->getMeta('selectable') == 1) echo 'selected="selected"';
    	echo '>Any user can select this charity</option>
    				<option value="2"';
    	if ( $this->content->getMeta('selectable') && $this->content->getMeta('selectable') == 2) echo 'selected="selected"';
    	echo '>Only Advocates can select this charity</option>
    				<option value="3"';
    	if ( $this->content->getMeta('selectable') && $this->content->getMeta('selectable') == 3) echo 'selected="selected"';
    	echo '>Admin can assign this charity</option>
    			</select>
    		</div>
    	';
        

    	echo '
    		<div>
    			<label for="rank">Rank<br /><span class="form-help-text">What is the order that this charity should be displayed in on the fundraiser profile page (relative integer)</span></label>
    			<input type="text" name="rank" id="rank"';
	
    	if ( $this->content->getMeta('rank') ) echo ' value="' . htmlspecialchars( $this->content->getMeta('rank') ) . '"';
    	echo ' />
    		</div>
    	';

    	echo '
    		<div>
    			<label for="url">Charity URL<br /><span class="form-help-text">Link to the charity\'s homepage</span></label>
    			<input type="url" name="url" id="url"';
	
    	if ( $this->content->getMeta('url') ) echo ' value="' . htmlspecialchars( $this->content->getMeta('url') ) . '"';
    	echo ' />
    		</div>
    	';
    }
}
