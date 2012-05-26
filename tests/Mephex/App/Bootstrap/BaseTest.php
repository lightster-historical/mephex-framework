<?php



class Mephex_App_Bootstrap_BaseTest
extends Mephex_Test_TestCase
{
	protected $_bootstrap;

	protected $_prev_auto_loader;
	
	
	
	protected function setUp()
	{
		parent::setUp();

		$this->_bootstrap	= new Stub_Mephex_App_Bootstrap_Base();
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base
	 */
	public function testExpectedParentClassExists()
	{
		$this->assertTrue(
			class_exists('Mephex_App_Bootstrap', false)
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::__construct
	 */
	public function testBaseBootstrapIsInstanceOfBootsrap()
	{
		$this->assertInstanceOf(
			'Mephex_App_Bootstrap',
			$this->_bootstrap
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::initAutoLoader
	 */
	public function testInitAutoLoaderPassesPassedAutoLoaderToSetUpAutoLoader()
	{
		$default_auto_loader	= Mephex_App_AutoLoader::getInstance();
		$auto_loader			= new Mephex_App_AutoLoader();

		$this->assertNotSame(
			$default_auto_loader,
			$auto_loader
		);

		$this->_bootstrap	= $this->getMock(
			'Mephex_App_Bootstrap_Base',
			array(
				'setUpAutoLoader'
			)
		);
		$this->_bootstrap
			->expects($this->once())
			->method('setUpAutoLoader')
			->with($this->equalTo($auto_loader))
			->will($this->returnValue($auto_loader));

		$this->_bootstrap->initAutoLoader($auto_loader);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::initAutoLoader
	 */
	public function testInitAutoLoaderPassesDefaultAutoLoaderToSetUpAutoLoader()
	{
		$default_auto_loader	= Mephex_App_AutoLoader::getInstance();

		$this->_bootstrap	= $this->getMock(
			'Mephex_App_Bootstrap_Base',
			array(
				'setUpAutoLoader'
			)
		);
		$this->_bootstrap
			->expects($this->once())
			->method('setUpAutoLoader')
			->will($this->returnValue($default_auto_loader));

		$this->_bootstrap->initAutoLoader();
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::setUpAutoLoader
	 */
	public function testSetUpAutoLoaderSetsAutoLoader()
	{
		$auto_loader		= new Mephex_App_AutoLoader();

		$this->assertAttributeSame(
			null,
			'_auto_loader',
			$this->_bootstrap
		);

		$this->_bootstrap->setUpAutoLoader($auto_loader);

		$this->assertAttributeSame(
			$auto_loader,
			'_auto_loader',
			$this->_bootstrap
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::setUpAutoLoader
	 */
	public function testSetUpAutoLoaderRegistersSpl()
	{
		$auto_loader		= $this->getMock(
			'Mephex_App_AutoLoader',
			array(
				'registerSpl'
			)
		);
		$auto_loader
			->expects($this->once())
			->method('registerSpl');

		$this->_bootstrap->setUpAutoLoader($auto_loader);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::setUpAutoLoader
	 */
	public function testSetUpAutoLoaderAddsDefaultClassLoaders()
	{
		$auto_loader		= new Mephex_App_AutoLoader();

		$this->_bootstrap	= $this->getMock(
			'Stub_Mephex_App_Bootstrap_Base',
			array(
				'addDefaultClassLoaders'
			),
			array(
				null
			)
		);
		$this->_bootstrap
			->expects($this->once())
			->method('addDefaultClassLoaders')
			->with($this->equalTo($auto_loader));

		$this->_bootstrap->setUpAutoLoader($auto_loader);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::setUpAutoLoader
	 */
	public function testSetUpAutoLoaderReturnsAutoLoader()
	{
		$auto_loader		= new Mephex_App_AutoLoader();

		$this->assertSame(
			$auto_loader,
			$this->_bootstrap->setUpAutoLoader($auto_loader)
		);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::getAutoLoader
	 * @depends testSetUpAutoLoaderSetsAutoLoader
	 */
	public function testGetAutoLoaderReturnsSetAutoLoader()
	{
		$auto_loader		= new Mephex_App_AutoLoader();

		$this->assertNull($this->_bootstrap->getAutoLoader());
		$this->_bootstrap->setUpAutoLoader($auto_loader);
		$this->assertSame($auto_loader, $this->_bootstrap->getAutoLoader());
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::addDefaultClassLoaders
	 */
	public function testAddDefaultClassLoadersCanBeAdded()
	{
		$auto_loader		= $this->getMock(
			'Mephex_App_AutoLoader',
			array(
				'addClassLoader'
			)
		);
		$auto_loader
			->expects($this->once())
			->method('addClassLoader')
			->with($this->equalTo(new Mephex_App_Class_Loader_PathOriented('Mephex_')));

		$this->_bootstrap->addDefaultClassLoaders($auto_loader);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::getFrontController
	 */
	public function testGetFrontControllerRetrievesFrontControllerFromResourceList()
	{
		$resource_list		= $this->getMock(
			'Mephex_App_Resource_List',
			array(
				'checkResourceType'
			)
		);
		$front_ctrl			= $this->getMock(
			'Mephex_Controller_Front_Base',
			null,
			array(
				$resource_list
			)
		);

		$resource_list
			->expects($this->once())
			->method('checkResourceType')
			->with(
				$this->equalTo('FrontController'),
				$this->equalTo('Default'),
				$this->equalTo('Mephex_Controller_Front_Base')
			)
			->will($this->returnValue($front_ctrl));

		$this->_bootstrap	= new Stub_Mephex_App_Bootstrap_Base();
		$this->_bootstrap->getFrontController($resource_list);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::run
	 */
	public function testRunRetrievesFrontController()
	{
		$resource_list		= new Mephex_App_Resource_List();

		$front_ctrl			= $this->getMock(
			'Mephex_Controller_Front_Base',
			array(
				'run'
			),
			array(
				$resource_list
			)
		);

		$this->_bootstrap	= $this->getMock(
			'Mephex_App_Bootstrap_Base',
			array(
				'getFrontController'
			),
			array(
				null
			)
		);
		$this->_bootstrap
			->expects($this->once())
			->method('getFrontController')
			->with($this->equalTo($resource_list))
			->will($this->returnValue($front_ctrl));

		$this->_bootstrap->run($resource_list);
	}



	/**
	 * @covers Mephex_App_Bootstrap_Base::run
	 */
	public function testRunRunsFrontController()
	{
		$resource_list		= new Mephex_App_Resource_List();

		$front_ctrl			= $this->getMock(
			'Mephex_Controller_Front_Base',
			array(
				'run',
			),
			array(
				$resource_list
			)
		);
		$front_ctrl
			->expects($this->once())
			->method('run');

		$this->_bootstrap	= $this->getMock(
			'Mephex_App_Bootstrap_Base',
			array(
				'getFrontController'
			),
			array(
				null
			)
		);
		$this->_bootstrap
			->expects($this->once())
			->method('getFrontController')
			->with($this->equalTo($resource_list))
			->will($this->returnValue($front_ctrl));

		$this->_bootstrap->run($resource_list);
	}
}
