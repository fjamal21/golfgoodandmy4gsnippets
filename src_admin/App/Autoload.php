<?php
namespace Src\App;

class Autoload
{
	public function __construct()
	{
		spl_autoload_register(function ($class) {

			$prefix = 'Src'; // Namespace prefix
			$base_dir = '../src_admin'; // Namespace base directory prefix
	
			// Look for the namespace prefix
			$len = strlen($prefix);
			if (strncmp($prefix, $class, $len) !== 0) {
				return;
			}
	
			// Get the relative class name
			$relative_class = substr($class, $len);
	
			$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
			
			if (file_exists($file)) require $file;
			//echo $file . "<br />";
		});
	}
}
