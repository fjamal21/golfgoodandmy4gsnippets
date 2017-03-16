<?php
/*
 * Description:
 * This file is a view file for the main admin page.
 */

include SRC . 'views/header.tpl.php';

?>

<h1>Admin</h1>

<?php
// Display the modules.
if ( ! empty( $modules ) ) {
	
	// Create a div to display modules
	echo '<div class="index-modules">';
	
	echo "<h2>Modules</h2>";
	
	// List the add-on modules
	foreach ( $modules as $module => $name) {
		
		// Only list a module if it's a directory and . or ..
		if ( ! in_array( $name, $ignore ) && is_dir( $dir . '/' . $name ) && substr($name, 0, 1) != '.') {

			echo '
			<div class="index-module">
				<p><a href="/' . $name . '">' . ucfirst($name) . '</a></p>
			</div>
			';
			
		}
		
	}
	
	// Close the modules div
	echo '
		</div>
	';
	
}

// Link to the Users page. (Admin only)
if ($user->get('level') >= 20) {
	
	// Create a div to display modules
	echo '<div class="index-modules">';
	
	echo '<h2>Core</h2>';
	
	echo '
	<div>
		<p><a href="/users">Users</a></p>
	</div>
	';
	
	// Close the core modules div
	echo '
		</div>
	';
	
}