<?php
/*
 * Description
 * This file creates the main administrative interface.
 */

// Scan the modules directory.
$dir = dirname( __FILE__ );
$dir = substr( $dir, 0, strrpos( $dir, '/' ) );
$modules = scandir( $dir );

// Modules to ignore
$ignore = array(
    'NotFound',
    'Users',
    'Index',
    'Login',
    'Logout'
);
//echo var_dump( $modules );
//echo $dir;
// Create the list of modules.

include 'index.tpl.php';