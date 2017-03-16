<?php
/* 
 * Description:
 * This file supplies the header group and navigation for the pages module
 */

echo '
	<header class="admin-header group">
		<h1>Prizes</h1>
		<nav>
			<ul>
';

echo '
				<li><a href="/prizes/add">New Prize</a></li>
';
			
if (isset($this->data['action'])) {
	echo'
				<li><a href="/prizes">All Prizes</a></li>
	';
}

echo '
			</ul>
		</nav>
	</header>
';