<?php



class Mephex_App_Bootstrap_BaseTest
extends Mephex_Test_TestCase
{
	protected $_prev_auto_loader;
	
	
	
	protected function setUp()
	{
		parent::setUp();

		// load Stub_Mephex_App_AutoLoader before we lose the autoloader  
		spl_autoload_call('Stub_Mephex_App_AutoLoader');
		spl_autoload_call('Stub_Mephex_App_Bootstrap_Base');
		
		$this->_prev_auto_loader	= Mephex_App_AutoLoader::getInstance();
		$this->_prev_auto_loader->unregisterSpl();
		Stub_Mephex_App_AutoLoader::clearInstance();
	}
	
	
	
	protected function tearDown()
	{
		parent::tearDown();

		Stub_Mephex_App_AutoLoader::restoreInstance($this->_prev_auto_loader);
		$this->_prev_auto_loader->registerSpl();
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::__construct
	 */
	public function testBaseBootstrapIsInstanceOfBootsrap()
	{
		$this->assertTrue(
			new Stub_Mephex_App_Bootstrap_Base(array(
				'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
				'action_name'		=> 'index'
			))
			instanceof Mephex_App_Bootstrap
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::getArguments
	 */
	public function testArgumentsPassedToConstructorAreReturnedByGetter()
	{
		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index',
			'cmd_line_arg'		=> '-v'
		);
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Base($args);

		$this->assertEquals($args, $bootstrap->getArguments());
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::init
	 */
	public function testInitIsCalledWhenBootstrapIsConstructed()
	{
		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index'
		);
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Base($args);

		$this->assertTrue($bootstrap->isInited());
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::setupAutoLoader
	 * @covers Mephex_App_Bootstrap_Base::getAutoLoader
	 */
	public function testAutoLoaderIsLoaded()
	{
		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index'
		);
		$bootstrap		= new Stub_Mephex_App_Bootstrap_Base($args);
		$auto_loader	= $bootstrap->getAutoLoader();

		$this->assertTrue(
			$auto_loader
			instanceof Mephex_App_AutoLoader
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::setupAutoLoader
	 * @covers Mephex_App_Bootstrap_Base::getAutoLoader
	 * @covers Mephex_App_Bootstrap_Base::addDefaultClassLoaders
	 */
	public function testDefaultClassLoadersAreRegistered()
	{
		$this->assertFalse(
			class_exists('Stub_Mephex_App_Bootstrap_Base_PrefixA1')
		);

		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index'
		);
		$bootstrap		= new Stub_Mephex_App_Bootstrap_Base($args);

		$this->assertTrue(
			class_exists('Stub_Mephex_App_Bootstrap_Base_PrefixA1')
		);
	}



	/**
	 * @depends testDefaultClassLoadersAreRegistered
	 * @covers Mephex_App_Bootstrap_Base::__destruct
	 */
	public function testDefaultClassLoadersAreUnregistered()
	{
		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index'
		);

		$bootstrap		= new Stub_Mephex_App_Bootstrap_Base($args);
		$this->assertTrue(
			class_exists('Stub_Mephex_App_Bootstrap_Base_PrefixA2')
		);
		unset($bootstrap);
		$this->assertFalse(
			class_exists('Stub_Mephex_App_Bootstrap_Base_PrefixA3')
		);

		$bootstrap		= new Stub_Mephex_App_Bootstrap_Base($args);
		$this->assertTrue(
			class_exists('Stub_Mephex_App_Bootstrap_Base_PrefixA2')
		);
		$this->assertTrue(
			class_exists('Stub_Mephex_App_Bootstrap_Base_PrefixA3')
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::getFrontController
	 */
	public function testFrontControllerIsLazyLoaded()
	{
		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index'
		);
		$bootstrap		= new Stub_Mephex_App_Bootstrap_Base($args);
		$front_ctrl		= $bootstrap->getFrontController();

		$this->assertTrue(
			$front_ctrl === $bootstrap->getFrontController()
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::run
	 */
	public function testFrontControllerCanBeRun()
	{
		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index'
		);
		$bootstrap		= new Stub_Mephex_App_Bootstrap_Base($args);
		$bootstrap->run();

		$front_ctrl		= $bootstrap->getFrontController();
		$action_ctrl	= $front_ctrl->getActionController();

		$this->assertEquals('index', $action_ctrl->getActionName());
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::runWithRouterOverride
	 */
	public function testFrontControllerCanBeRunWithRouterOverride()
	{
		$args	= array(
			'action_ctrl_name'	=> 'Stub_Mephex_Controller_Action_Base',
			'action_name'		=> 'index'
		);
		$bootstrap		= new Stub_Mephex_App_Bootstrap_Base($args);
		$router			= new Stub_Mephex_Controller_Router(
			'Stub_Mephex_Controller_Action_Base',
			'builder'
		);
		$bootstrap->runWithRouterOverride($router);

		$front_ctrl		= $bootstrap->getFrontController();
		$action_ctrl	= $front_ctrl->getActionController();

		$this->assertEquals('builder', $action_ctrl->getActionName());
	}
}