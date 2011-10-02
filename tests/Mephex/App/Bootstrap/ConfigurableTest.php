<?php



class Mephex_App_Bootstrap_ConfigurableTest
extends Mephex_Test_TestCase
{
	protected $_prev_auto_loader;
	
	
	
	protected function setUp()
	{
		parent::setUp();

		// load Stub_Mephex_App_AutoLoader before we lose the autoloader  
		spl_autoload_call('Stub_Mephex_App_AutoLoader');
		spl_autoload_call('Stub_Mephex_App_Bootstrap_Configurable');
		
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
	 * @covers Mephex_App_Bootstrap_Configurable::__construct
	 */
	public function testConfigurableBootstrapIsInstanceOfBootsrap()
	{
		$args		= array();
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Configurable(
			$args,
			$config
		);

		$this->assertTrue($bootstrap instanceof Mephex_App_Bootstrap);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Configurable::getConfig
	 */
	public function testConfigPassedToBootstrapIsSameRetrievedFromBootstrap()
	{
		$args		= array();
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Configurable(
			$args,
			$config
		);

		$this->assertTrue($config === $bootstrap->getConfig());
	}



	/**
	 * @covers Mephex_App_Bootstrap_Configurable::generateFrontController
	 */
	public function testFrontControllerIsInstanceOfConfigurableFrontController()
	{
		$args		= array();
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Configurable(
			$args,
			$config
		);
		$front_ctrl	= $bootstrap->generateFrontController();

		$this->assertTrue(
			$front_ctrl
			instanceof Mephex_Controller_Front_Configurable
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Configurable::generateFrontController
	 */
	public function testConfigPassedToBootstrapIsSameRetrievedFromFrontController()
	{
		$args		= array();
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Configurable(
			$args,
			$config
		);
		$front_ctrl	= $bootstrap->generateFrontController();

		$this->assertTrue($config === $front_ctrl->getConfig());
	}



	/**
	 * @covers Mephex_App_Bootstrap_Configurable::generateFrontController
	 */
	public function testConfigDefaultSystemGroupIsMephex()
	{
		$args		= array();
		$config		= new Mephex_Config_OptionSet();
		$config->set('mephex', 'option_name', 'mephex_value');
		$config->set('other', 'option_name', 'other_value');
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Configurable(
			$args,
			$config
		);
		$front_ctrl	= $bootstrap->generateFrontController();

		$this->assertEquals(
			'mephex_value',
			$front_ctrl->getSystemConfigOption('option_name')
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Configurable::generateFrontController
	 */
	public function testConfigDefaultSystemGroupCanBeSetInConfigOptions()
	{
		$args		= array();
		$config		= new Mephex_Config_OptionSet();
		$config->set('default', 'system_group', 'other');
		$config->set('mephex', 'option_name', 'mephex_value');
		$config->set('other', 'option_name', 'other_value');
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Configurable(
			$args,
			$config
		);
		$front_ctrl	= $bootstrap->generateFrontController();

		$this->assertEquals(
			'other_value',
			$front_ctrl->getSystemConfigOption('option_name')
		);
	}
}