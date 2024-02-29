<?php 
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 0); // in the server change on 0
    ini_set('display_startup_errors', 0); // in the server change on 0

	spl_autoload_register(function($className){
		$path = strtolower($className) . ".php";
		if(file_exists($path)) {
			require_once($path);
		} else {
			echo "File $path is not found.";
		}
	})

 ?>