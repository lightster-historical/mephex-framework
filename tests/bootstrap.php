<?php



function bootstrap()
{
	define('PATH_TEST_ROOT', dirname(__FILE__));

	set_include_path(get_include_path() . PATH_SEPARATOR . PATH_TEST_ROOT);

	require_once 'Mephex/App/AutoLoader.php';
	require_once 'Mephex/App/ClassLoader/PathOriented.php';

	$auto_loader	= Mephex_App_AutoLoader::getInstance();
	$auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Mephex_'));
	$auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Stub_'));
	$auto_loader->registerSpl();
}



bootstrap();