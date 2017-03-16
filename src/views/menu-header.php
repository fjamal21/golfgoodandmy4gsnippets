<?php
/*
 * Define the header navigation panel.
 *
 * Logo on every page but index
 * Swap out register and login when logged in
 * Swap out navigation for menu control link at small sizes
 */
if ( ! isset($p) ) {
    $p = '';
}


function menu_header_link( $content, $url, $current = null ) {
    $item = "\n\t\t\t\t\t" . '<li><a href="'. $url . '" class="menu-header-' . $url . '';
								
	if ( ! isset($current) || $current == $url) {
		$item .= ' current';
	}
							
	$item .= '">' . $content . "</a></li>";
    
    return $item;
}

?>

            <div class="wrap group">
			<?php
		    
            if ( false ) {
            //if ( ! isset( $p ) || $p != 'index' ) {
                ?>
<!--
				<div class="logo">
					<a href="/">
						<img src="/assets/img/elements/logo_xl.png" alt="Golf 4 Good" />
					</a>
				</div>
-->            
                <?php
            }
            
			?>
	
        		<nav class="menu-header" role="navigation">

                    
        			<ul><?php

                        echo menu_header_link( 'Home', 'http://www.myg4g.org/
', $p );
                        echo menu_header_link( 'About', 'about', $p );
                        echo menu_header_link( 'Prizes', 'prizes', $p );
                        //echo menu_header_link( 'Charities', 'charities', $p );
                        //echo menu_header_link( 'Media', 'media', $p );
                        echo menu_header_link( 'Donate', 'donate', $p );
                       
                        if ( ! $user->isLoggedIn() ) {

                            echo menu_header_link( 'Register', 'register', $p );
                            echo menu_header_link( 'Login', 'login', $p );
                            
                        }
                        ?>
                        
    				</ul>
			    
                    <a href="#site-navigation" class="control menu-header-menu">Menu</a>
                    
        		</nav>
                
                <div class="logo">
                    
                    <div class="logo-horiz">
                         <?php if ($page_title!="Home | Golf for Good") { ?>
<a href="/"><img src="/assets/img/elements/logo_xl.png" alt="Golf4Good"></a>
<?php }  ?>
                    </div>

                    <div class="logo-vert">
                        <?php if ($page_title =="Home | Golf for Good") { ?>
<a href="/"><img src="/assets/img/elements/logo_xl.png" alt="Golf4Good"></a>
<?php }  ?>
                    </div><!-- .logo-vert -->
                    
                </div>
	
    		</div>
            
            <?php
				
			/* echo '		<nav class="main-navigation-social">
						<ul>
							<li><a href="http://facebook.com/givegolfevent" target="_blank"><img src="/assets/img/icons/icon_facebook.png" /><span class="nav-social-text">Like us on Facebook</span></a></li>
							<li><a href="http://twitter.com/givegolfevent" target="_blank"><img src="/assets/img/icons/icon_twitter.png" /><span class="nav-social-text">Follow us on Twitter</span></a></li>
							<?php 
							// echo '<li><a href="http://instagram.com/givegolf"><img src="/assets/img/icons/icon_instagram.png" /><span class="nav-social-text">Follow us on Instagram</span></a></li>';
							?>
						</ul>
					</nav>
                ';
            */
            ?>
                