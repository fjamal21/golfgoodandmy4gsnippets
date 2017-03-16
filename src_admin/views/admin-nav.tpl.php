<?php
/*
 * Description:
 * Administration navigation.
 */

?>

<div class="admin-navigation">
	
	<nav class="admin-navigation-primary">
		<ul>
			<li><a href="<?php echo $config->get('site_url'); ?>"><?php echo $config->get('site_name'); ?></a></li>
			<li><a href="/">Admin</a></li>
		</ul>
	</nav>
	
	<nav class="admin-navigation-secondary">
		<ul>
			<li><a href="/logout">Log Out</a></li>
		</ul>
	</nav>
	
</div>