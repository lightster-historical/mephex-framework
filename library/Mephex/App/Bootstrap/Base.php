<?php



require_once 'Mephex/App/Bootstrap.php';



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



	public function __construct()
	{
	}



	/**
	 * Initializes the auto loader.
	 *
	 * @param Mephex_App_AutoLoader $auto_loader - the auto loader to use
	 * @return Mephex_App_AutoLoader
	 */
	public function initAutoLoader(Mephex_App_AutoLoader $auto_loader = null)
	{
		if(!$auto_loader) {
			require_once 'Mephex/App/AutoLoader.php';
			$auto_loader	= Mephex_App_AutoLoader::getInstance();
		}

		return $this->setUpAutoLoader($auto_loader);
	}



	/**
	 * Sets up the auto loader.
	 *
	 * @param Mephex_App_AutoLoader $auto_loader - the auto loader to use
	 * @return Mephex_App_AutoLoader
	 */
	protected function setUpAutoLoader(Mephex_App_AutoLoader $auto_loader)
	{
		require_once 'Mephex/App/ClassLoader/PathOriented.php';

		$this->_auto_loader	= $auto_loader;
		$this->_auto_loader->registerSpl();
		$this->addDefaultClassLoaders($this->_auto_loader);

		return $this->_auto_loader;
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
		$auto_loader
			->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Mephex_'));
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
	 * Getter for front controller.
	 *
	 * @param Mephex_App_Resource_List $resource_list
	 * @return Mephex_Controller_Front_Base
	 */
	protected function getFrontController(Mephex_App_Resource_List $resource_list)
	{
		return $resource_list->checkResourceType(
			'FrontController',
			'Default',
			'Mephex_Controller_Front_Base'
		);
	}



	/**
	 * Runs the application.
	 *
	 * @param Mephex_App_Resource_List $resource_list
	 * @return Mephex_Controller_Front_Base
	 */
	public function run(Mephex_App_Resource_List $resource_list)
	{
		$front_ctrl	= $this->getFrontController($resource_list);
		$front_ctrl->run();
		return $front_ctrl;
	}
}