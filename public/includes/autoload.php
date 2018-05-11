<?php
/*Register a function with the spl provided __autoload queue. 
If the queue is not yet activated it will be activated.*/

$class_name = ""; //Hard-coded

spl_autoload_register(function ($class_name) {
	$ini = parse_ini_file(__DIR__."/../../config/config.ini");
	$directory = $ini['directory'];
	include $_SERVER['DOCUMENT_ROOT'] . $directory . $class_name . '.php';
}
);
