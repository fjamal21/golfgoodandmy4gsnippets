<?php

function userMenuLink( $url, $content, $current ) {
    $link = '<li><a href="/' . $url . '"';
    if ( $url == $current ) {
        $link .= ' class="current"';
    }
    $link .= '>' . $content . '</a></li>';
    return $link;
}
// Show the correct menu depending on whether the the user is logged in or not, and depending on the user level.
if ( $user->isLoggedIn() ) { // The user is logged in and does not have admin access.
	
	echo '

		<nav class="main-navigation-user group">
			<div class="wrap">
				<ul>
	';
	
	// If the user hasn't completed their profile, show only the link to the create profile page.
	
	if ( ! $user->hasCompletedProfile() ) { // The user has NOT created their profile.
		
		echo '
					<li><a href="/profile">Create Your Profile</a></li>
		';
		
	} else { // The user HAS created their profile.
        
        echo userMenuLink( 'profile', 'My Profile', '' );
        echo userMenuLink( 'guide', 'Get Donations', '' );
        echo userMenuLink( 'donors', 'Donors', '' );
        echo userMenuLink( 'scorecard', 'Holes', '' );
        echo userMenuLink( 'settings', 'Settings', '' );
		
	}
	
	echo '
					<li class="main-navigation-signout"><a href="/logout">Sign Out</a></li>
				</ul>
			</div>
		</nav>
';

}