<?php

if (!isset($page_title)) {
	$page_title = 'Golf for Good';
} else {
	$page_title = $page_title . ' | Golf for Good';
}

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $page_title; ?></title>

	<link rel="stylesheet" href="/assets/css/style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
          
        <!--<link rel="stylesheet" type="text/css" href="assets/css/alternate-style.css">-->
	<link rel="icon" type="image/png" href="/favicon.png" />
	<link rel="stylesheet" type="text/css" href="alternate-style.css">
	<link rel="apple-touch-icon" href="touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="76x76" href="touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="120x120" href="touch-icon-120x120.png">
	
	<?php
	
	// If there are any JavaScript files, include them.
	if (isset($js)) {
		echo $js;
	}
		
	?>

</head>
<body class="modal-background">

	<div class="container">
	
		<header class="header-simple group">
			
			<div class="wrap group">
			
				<div class="logo">
					<a href="/">
						
<img src="/assets/img/elements/logo_xl.png" alt="Golf for Good">
					</a>
				</div>
				
			</div>
			
		</header>


		<div class="content-small">
