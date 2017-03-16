<?php
/* 
 * Description:
 * This file supplies the header group and navigation for the pages module
 */

echo '
	<header class="admin-header group">
		<h1>Pages</h1>
		<nav>
			<ul>
';

echo '
				<li><a href="/pages/add">New Page</a></li>
';
			
if (isset($this->action)) {
	echo'
				<li><a href="/pages">All Pages</a></li>
	';
}

echo '
			</ul>
		</nav>
	</header>
';