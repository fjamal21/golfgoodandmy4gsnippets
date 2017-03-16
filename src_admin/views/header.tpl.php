<?php
/*
 * Description:
 * This file creates the HTML header for the admin pages.
 */

if (!isset($page_title)) $page_title = 'Admin | Givegolf';

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $page_title; ?></title>
	
	<meta name="viewport" description="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	
	<link rel="stylesheet" href="/assets/css/style.css" />
	
</head>
<body>
	
	<?php 
    if ( $user->isLoggedIn() ) {
        include 'admin-nav.tpl.php';
    }
    ?>

	<div class="admin-container">