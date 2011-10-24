<?php



class Mephex_App_Bootstrap_HttpTest
extends Mephex_Test_TestCase
{
	protected $_prev_auto_loader;
	
	
	
	protected function setUp()
	{
		parent::setUp();

		// load Stub_Mephex_App_AutoLoader before we lose the autoloader  
		spl_autoload_call('Stub_Mephex_App_AutoLoader');
		spl_autoload_call('Stub_Mephex_App_Bootstrap_Http');
		
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
	 * @covers Mephex_App_Bootstrap_Http::__construct
	 */
	public function testHttpBootstrapIsInstanceOfConfigurableBootstrap()
	{
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);

		$this->assertTrue($bootstrap instanceof Mephex_App_Bootstrap_Configurable);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Http::getConfig
	 */
	public function testConfigPassedToBootstrapIsSameRetrievedFromBootstrap()
	{
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);

		$this->assertTrue($config === $bootstrap->getConfig());
	}



	/**
	 * @covers Mephex_App_Bootstrap_Http::generateFrontController
	 */
	public function testFrontControllerIsInstanceOfConfigurableFrontController()
	{
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);
		$front_ctrl	= $bootstrap->generateFrontController(
			new Mephex_App_Arguments()
		);

		$this->assertTrue(
			$front_ctrl
			instanceof
			Mephex_Controller_Front_Configurable
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Http::generateFrontController
	 */
	public function testArgumentsReturnedByFrontControllerAreHttpArguments()
	{
		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);
		$front_ctrl	= $bootstrap->generateFrontController(
			new Mephex_App_Arguments()
		);

		$this->assertTrue(
			$front_ctrl->getArguments()
			instanceof
			Mephex_App_Arguments_Http
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Http::generateFrontController
	 */
	public function testExpectedHttpInfoArgumentsAreReturnedFromFrontControllerArguments()
	{
		$_SERVER['unitTesting']	= 'SERVER';

		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);
		$front_ctrl	= $bootstrap->generateFrontController(
			new Mephex_App_Arguments()
		);

		$args	= $front_ctrl->getArguments()->getHttpConnectionInfo();
		$this->assertEquals(
			'SERVER',
			$args->get('unitTesting')
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Http::generateFrontController
	 */
	public function testExpectedPostRequestArgumentsAreReturnedFromFrontControllerArguments()
	{
		$_POST['unitTesting']	= 'POST';

		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);
		$front_ctrl	= $bootstrap->generateFrontController(
			new Mephex_App_Arguments()
		);

		$args	= $front_ctrl->getArguments()->getPostRequest();
		$this->assertEquals(
			'POST',
			$args->get('unitTesting')
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Http::generateFrontController
	 */
	public function testExpectedGetRequestArgumentsAreReturnedFromFrontControllerArguments()
	{
		$_GET['unitTesting']	= 'GET';

		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);
		$front_ctrl	= $bootstrap->generateFrontController(
			new Mephex_App_Arguments()
		);

		$args	= $front_ctrl->getArguments()->getGetRequest();
		$this->assertEquals(
			'GET',
			$args->get('unitTesting')
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Http::generateFrontController
	 */
	public function testExpectedOtherArgumentsAreReturnedFromFrontControllerArguments()
	{
		$other['unitTesting']	= 'other';

		$config		= new Mephex_Config_OptionSet();
		$bootstrap	= new Stub_Mephex_App_Bootstrap_Http($config);
		$front_ctrl	= $bootstrap->generateFrontController(
			new Mephex_App_Arguments($other)
		);

		$args	= $front_ctrl->getArguments();
		$this->assertEquals(
			'other',
			$args->get('unitTesting')
		);
	}
}