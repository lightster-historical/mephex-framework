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
	 * Lazy-loaded front controller.
	 *
	 * @var Mephex_Controller_Front_Base
	 */
	private $_front_ctrl;


	/**
	 * Arguments passed into the program.
	 *
	 * @ar array
	 */
	private $_arguments;



	/**
	 * @param array $arguments - the arguments passed into the program
	 */
	public function __construct(array $arguments)
	{
		$this->_arguments	= $arguments;

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
	 * Getter for arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return $this->_arguments;
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
	protected abstract function generateFrontController();



	/**
	 * Lazy-loading getter for front controller.
	 *
	 * @return Mephex_Controller_Front_Base
	 */
	protected function getFrontController()
	{
		if(null === $this->_front_ctrl) {
			$expected	= new Mephex_Reflection_Class(
				'Mephex_Controller_Front_Base'
			);
			$this->_front_ctrl	= $expected->checkObjectType(
				$this->generateFrontController()
			);
		}

		return $this->_front_ctrl;
	}



	/**
	 * Runs the application.
	 *
	 * @return void
	 */
	public function run()
	{
		return $this->getFrontController()->run();
	}



	/**
	 * Runs the application, overriding the default router.
	 *
	 * @return void
	 */
	public function runWithRouterOverride(Mephex_Controller_Router $router)
	{
		return $this->getFrontController()->runWithRouterOverride($router);
	}
}