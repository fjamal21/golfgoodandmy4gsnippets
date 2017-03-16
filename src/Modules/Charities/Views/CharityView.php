<?php
namespace Src\Modules\Charities\Views;

use Src\Includes\SuperClasses\AbstractView;
use Src\Config\Config;
use Src\Includes\User;
use Src\Includes\UserVideo;

class CharityView extends AbstractView
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
        
        $content = $this->data['content'];
        $analytics = $this->analytics->getCode();
        
        //print_r( $content );

        if ( $content->get('meta_description') ) {
        	$meta_description = $content->get('meta_description');
        }

        $page_title = $content->get('title');
        
        include SRC . 'views/header.tpl.php';


        // The page template has a main content area and a sidebar.
        // This requires a wrapper and subsections.

        ?>

        <div class="content">
	
        	<header class="content-header">
        		<div class="wrap">
        			<h1 class="content-title"><?php echo $content->get('title'); ?></h1>
        			<?php 
        			if ( $content->getMeta('tagline') ) {
        				echo '
        			<p class="content-tagline">' . $content->getMeta('tagline') . '</p>
        				';
        			}?>
        		</div>
        	</header>
	
	
        	<div class="wrap group">
		
        		<div>
	
        			<div class="content-main group">
				
        				<div class="content-wrap">

                    		<?php if ( $content->get('image') ) {
                        			echo '
                    				<div class="content-charity-logo content-charity-logo-' . $this->data['map']['guid'] . '">
                    					<img src="/content_image/' . $content->get('image') . '">
                    				</div>
                    			';
                    		}?>
                            
        					<?php if ( $content->get('summary') ) {
        						echo '
        						<div class="content-summary">
        							<p>' . $content->get('summary') . '</p>
        						</div>
        						';
        					}?>
		
		
        					<div class="content-content">
						
        						<?php echo $content->get('content'); ?>
					
					
        					</div>
                            
					
        					<?php
        					// Check for a video.
        					if ( $content->getMeta('video') ) {
						
                                $video = new UserVideo( $content->getMeta('video') );
        						
                                $video->display();
        					}
					
        					// If there is a description for the video, display it.
        					if ( $content->getMeta('video_description') ) {
						
        						echo '
        							<p class="content-video-description">' . $content->getMeta('video_description') . '</p>
        						';
						
        					}
						
        					?>
		
        				</div> <!-- .content-wrap -->
			
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
