<?php

if (!isset($page_title)) {
	$page_title = 'Golf for Good';
} else {
	$page_title = $page_title . ' | Golf for Good';
}

if (!isset($meta_description)) {
	$meta_description = "Play 100 holes of golf in Canada's largest golf charity event. Help change the fundraising game.";
}
	
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $page_title; ?></title>
	
	<meta name="description" content="<?php echo $meta_description; ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<?php
	
// If this is the homepage, include additional fonts for the carousel. Roboto Slab
if (isset($font) && $font == 'roboto slab') {
	echo "
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300,700' rel='stylesheet' type='text/css'>
	";
}
?>

	<link rel="stylesheet" href="/assets/css/style.css" />
       <link rel="stylesheet" type="text/css" href="alternate-style.css">

<link rel="stylesheet" type="text/css" href="assets/css/alternate-style.css">
	<link rel="icon" type="image/png" href="/favicon.png" />
         <link rel="stylesheet" type="text/css" href="alternate-style.css">
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
	
<?php
	
// If this is the homepage, include js for the carousels.
if (isset($js) && $js == 'carousel') {
	//include '/assets/js/carousel.js';
}
?>
</head>
<body<?php
if ( isset($p) ) {
    echo ' class="page-' . $p . '"';
}
?>>

	<div id="top" class="container">
	
    	<?php
    		include 'menu-user.php';
    	?>
        
		<header class="header group">
			<?php
				include 'menu-header.php';
 
			?>
		</header>
		

		<div class="group">
