<?php
/* 
 * Description:
 * This file supplies the header group and navigation for the pages module
 */

echo '
	<header class="admin-header group">
		<h1>Blog</h1>
		<nav>
			<ul>
';

echo '
				<li><a href="/blog/add">New Blog Post</a></li>
';
			
if (isset($this->action)) {
	echo'
				<li><a href="/blog">All Posts</a></li>
	';
}

echo '
			</ul>
		</nav>
	</header>
';