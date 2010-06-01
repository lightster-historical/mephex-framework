<?php



function bootstrap()
{
	require_once 'Zend/Loader/Autoloader.php';
	$loader	= Zend_Loader_Autoloader::getInstance();
	$loader->registerNamespace('Mephex_');
	$loader->registerNamespace('Stub_');
}



bootstrap();