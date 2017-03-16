<?php
/* 
 * Description:
 * This file supplies the header group and navigation for the charities module
 */

echo '
	<header class="admin-header group">
		<h1>Charities</h1>
		<nav>
			<ul>
';

echo '
				<li><a href="/charities/add">New Charity</a></li>
';

echo '
				<li><a href="/charities/default">Default Charity</a></li>
';
			
if (isset($this->data['action'])) {
	echo'
				<li><a href="/charities">All Charities</a></li>
	';
}

echo '
			</ul>
		</nav>
	</header>
';