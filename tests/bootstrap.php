<?php



define('PATH_TEST_ROOT', dirname(__FILE__));

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));



function __autoload($class_name)
{
	$path	= '' . str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
	
//	var_dump("Loading '{$path}'");
	
	require_once $path;
}



function bootstrap()
{
//	require_once 'Zend/Loader/Autoloader.php';
//	$loader	= Zend_Loader_Autoloader::getInstance();
//	$loader->registerNamespace('Mephex_');
//	$loader->registerNamespace('Stub_');
	
}



bootstrap();