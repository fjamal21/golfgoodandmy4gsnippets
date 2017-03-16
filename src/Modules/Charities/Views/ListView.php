<?php
namespace Src\Modules\Charities\Views;

use Src\Includes\SuperClasses\AbstractView;
use Src\Config\Config;
use Src\Includes\User;

class ListView extends AbstractView
{
    /*
     * Run
     */
    public function run()
    {
        $this->display();
    }
    
    /*
     * Display
     */
    protected function display()
    {
        $config = Config::getInstance();
        $user = User::getInstance();
        
        $list_obj = $this->data['content'];
        $list = $list_obj->get();
        $analytics = $this->analytics->getCode();
        
        $page_title = 'Charities';

        $meta_description = "Play 100 holes of golf for Canadian Men’s Health Foundation in Canada's largest golf charity event. Don’t change much, golf for good.";
        
        include SRC . 'views/header.tpl.php';

        ?>

        <div class="content">
	
        	<header class="content-header">
        		<div class="wrap">
        			<h1 class="content-title">Charities</h1>
        			<?php 
        			if ( isset($this->data['tagline'] ) && !empty($this->data['tagline'])) {
        				echo '
        			<p class="content-tagline">' . $this->data['tagline'] . '</p>
        				';
        			}?>
        		</div>
        	</header>
	
        	<div class="wrap group">
		
        		<div>
	
        			<div class="content-main group">
				
        	<?php
	
        	// If there is a description, output it.
        	if (isset( $this->data['description'] ) && !empty($this->data['description'])) {
        		echo '
        			<p class="prizes-description">' . $this->data['description'] . '</p>
        		';
        	}
	
        	// Initiallize a counter
        	$i = 0;
	
        	// If there are prizes, output them.
        	foreach ($list as $row) {
		
        		// Open the div.
        		echo '
        			<div class="teaser charities-' . $row['guid'];
		
        		// If the teaser has an image, give it a special class.
        		if ( $row['image'] ) {
        			echo ' teaser-with-image';
        		}
		
        		// Close the tag.
        		echo '">
        		';
		
        		// Create a container for the textual content.
        		echo '
        				<div class="teaser-content group">
        		';
                
        		if ( $row['image'] ) {
        			echo '
        				<div class="teaser-charity-logo">
        					<img src="content_image/' . $row['image'] . '" />
        				</div>
        			';
        		}
                
        		// Output the title.
        		echo '
        						<h2><a href="/' . $row['guid'] . '">' . $row['title'] . '</a></h2>
        		';
		
        		// Output the summary, if it's set.
        		if (!empty($row['summary'])) {
        			echo '
        					<p class="teaser-summary">' . $row['summary'] . '</p>
        			';
        		}
		
        		// Link to a dedicated page.
        		echo '
        					<p class="link-button teaser-link"><a href="/' . $row['guid'] . '">Learn More</a></p>
        		';
		
        		// Close the div.
        		echo '
        				</div>
        			</div>
        		';
		
        	}
        	?>
	
		
        			</div> <!-- .content-main -->


        			<div class="content-sidebar">
	
        	<?php
        	// Include the sidebar
        	include SRC . 'Modules/sidebar/sidebar.inc.php';
	
        	?>
	
        			</div> <!-- .content-sidebar -->
			
        		</div>

        	</div> <!-- .wrap -->
	
        </div> <!-- .content -->
        
        <?php
        include SRC . 'views/footer.tpl.php';
    }
}
