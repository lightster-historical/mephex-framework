<?php



require_once 'Mephex/App/Bootstrap.php';
require_once 'Mephex/Config/OptionSet.php';



/**
 * Abstract class for bootstrapping an application.
 * 
 * @author mlight
 */
abstract class Mephex_App_Bootstrap_Base
extends Mephex_App_Bootstrap
{
	/**
	 * The application's auto loader.
	 *
	 * @var Mephex_App_AutoLoader
	 */
	private $_auto_loader;



	/**
	 * @param array $arguments - the arguments passed into the program
	 */
	public function __construct()
	{
		$this->init();
	}



	public function __destruct()
	{
		$this->_auto_loader->unregisterSpl();
	}



	/**
	 * Initializes the application.
	 *
	 * @return void
	 */
	protected function init()
	{
		$this->setupAutoLoader();
	}



	/**
	 * Sets up the auto loader.
	 *
	 * @return void
	 */
	protected function setupAutoLoader()
	{
		require_once 'Mephex/App/AutoLoader.php';
		require_once 'Mephex/App/ClassLoader/PathOriented.php';

		$this->_auto_loader	= Mephex_App_AutoLoader::getInstance();
		$this->_auto_loader->registerSpl();
		$this->addDefaultClassLoaders($this->_auto_loader);
	}



	/**
	 * Adds the default class loaders to the application auto loader.
	 *
	 * @param Mephex_App_AutoLoader $auto_loader - the auto loader to add
	 *		the class loaders to
	 * @return void
	 */
	protected function addDefaultClassLoaders(Mephex_App_AutoLoader $auto_loader)
	{
		$auto_loader->addClassLoader(
			new Mephex_App_ClassLoader_PathOriented('Mephex_')
		);
	}



	/**
	 * Getter for auto loader.
	 *
	 * @return Mephex_App_AutoLoader
	 */
	public function getAutoLoader()
	{
		return $this->_auto_loader;
	}



	/**
	 * Generates the front controller to be used by the application.
	 *
	 * @return Mephex_Controller_Front_Base
	 */
	protected abstract function generateFrontController(
		Mephex_App_Arguments $arguments
	);



	/**
	 * Getter for front controller.
	 *
	 * @param Mephex_App_Arguments $arguments - the arguments to pass to the 
	 *		front controller
	 * @return Mephex_Controller_Front_Base
	 */
	protected function getFrontController(Mephex_App_Arguments $arguments)
	{
		$expected	= new Mephex_Reflection_Class(
			'Mephex_Controller_Front_Base'
		);
		return $expected->checkObjectType(
			$this->generateFrontController($arguments)
		);
	}



	/**
	 * Runs the application.
	 *
	 * @param Mephex_App_Arguments $arguments - the arguments to pass to the 
	 *		front controller
	 * @return Mephex_Controller_Front_Base
	 */
	public function run(Mephex_App_Arguments $arguments)
	{
		$front_ctrl	= $this->getFrontController($arguments);
		$front_ctrl->run($arguments);
		return $front_ctrl;
	}



	/**
	 * Runs the application, overriding the default router.
	 *
	 * @param Mephex_App_Arguments $arguments - the arguments to pass to the 
	 *		front controller
	 * @param Mephex_Controller_Router $router - the router to use
	 * @return Mephex_Controller_Front_Base
	 */
	public function runWithRouterOverride(
		Mephex_App_Arguments $arguments,
		Mephex_Controller_Router $router
	)
	{
		$front_ctrl	= $this->getFrontController($arguments);
		$front_ctrl->runWithRouterOverride($router);
		return $front_ctrl;
	}
}