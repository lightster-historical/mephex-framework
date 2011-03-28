<?php



class Mephex_App_AutoLoaderTest
extends Mephex_Test_TestCase
{
	protected $_auto_loader;
	
	protected $_prev_auto_loader;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_auto_loader	= new Mephex_App_AutoLoader();
		$this->_auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_AutoLoader_PrefixA'));
		$this->_auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_AutoLoader_PrefixB'));
		// the 'non-loader' will throw an exception if the class has already been loaded
		$this->_auto_loader->addClassLoader(new Stub_Mephex_App_ClassLoader_NonLoader());
		
		// load Stub_Mephex_App_AutoLoader before we lose the autoloader  
		spl_autoload_call('Stub_Mephex_App_AutoLoader');
		
		$this->_prev_auto_loader	= Mephex_App_AutoLoader::getInstance();
		$this->_prev_auto_loader->unregisterSpl();
		Stub_Mephex_App_AutoLoader::clearInstance();
	}
	
	
	
	protected function tearDown()
	{
		parent::tearDown();
		
		$this->_auto_loader->unregisterSpl();

		Stub_Mephex_App_AutoLoader::restoreInstance($this->_prev_auto_loader);
		$this->_prev_auto_loader->registerSpl();
	}
	
	
	
	/**
	 * @covers Mephex_App_AutoLoader::getInstance
	 */
	public function testGetInstanceReturnsAutoLoaderInstance()
	{
		$this->assertTrue(Mephex_App_AutoLoader::getInstance() instanceof Mephex_App_AutoLoader);
	}
	
	
	
	/**
	 * @covers Mephex_App_AutoLoader::getInstance
	 */
	public function testGetInstanceConsistentlyReturnsSameInstance()
	{
		$this->assertTrue(Mephex_App_AutoLoader::getInstance() === Mephex_App_AutoLoader::getInstance());
	}
	
	
	
	/**
	 * @covers Mephex_App_AutoLoader::__construct
	 * @covers Mephex_App_AutoLoader::addClassLoader
	 * @covers Mephex_App_AutoLoader::loadClass
	 */
	public function testAutoLoaderCanLoadClass()
	{
		$this->assertFalse(class_exists('Stub_Mephex_App_AutoLoader_PrefixA1', false));
		$this->_auto_loader->loadClass('Stub_Mephex_App_AutoLoader_PrefixA1');
		$this->assertTrue(class_exists('Stub_Mephex_App_AutoLoader_PrefixA1', false));
	}
	
	
	
	/**
	 * @covers Mephex_App_AutoLoader::loadClass
	 */
	public function testAutoLoaderCanUseSecondaryClassLoader()
	{
		$this->assertFalse(class_exists('Stub_Mephex_App_AutoLoader_PrefixB1', false));
		$this->_auto_loader->loadClass('Stub_Mephex_App_AutoLoader_PrefixB1');
		$this->assertTrue(class_exists('Stub_Mephex_App_AutoLoader_PrefixB1', false));
	}
	
	
	
	/**
	 * @covers Mephex_App_AutoLoader::loadClass
	 */
	public function testAutoLoaderDoesNotAttemptToLoadAnAlreadyLoadedClass()
	{
		$this->_auto_loader->loadClass('Mephex_App_AutoLoader');
		$this->_auto_loader->loadClass('Mephex_App_AutoLoader');
	}
	
	
	
	/**
	 * @covers Mephex_App_AutoLoader::registerSpl
	 */
	public function testAutoLoaderCanRegisterItselfWithSpl()
	{
		$this->_auto_loader	= new Mephex_App_AutoLoader();
		$this->_auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_AutoLoader_PrefixA'));
		$this->_auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_AutoLoader_PrefixB'));
		
		$this->assertFalse(class_exists('Stub_Mephex_App_AutoLoader_PrefixA2', false));
		$this->assertFalse(class_exists('Stub_Mephex_App_AutoLoader_PrefixA2', true));
		$this->_auto_loader->registerSpl();
		$this->assertTrue(class_exists('Stub_Mephex_App_AutoLoader_PrefixA2', true));
	}
	
	
	
	/**
	 * @covers Mephex_App_AutoLoader::unregisterSpl
	 * @depends testAutoLoaderCanRegisterItselfWithSpl
	 */
	public function testAutoLoaderCanUnregisterItselfWithSpl()
	{
		$this->_auto_loader	= new Mephex_App_AutoLoader();
		$this->_auto_loader->registerSpl();
		$this->_auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_AutoLoader_PrefixA'));
		$this->_auto_loader->addClassLoader(new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_AutoLoader_PrefixB'));
		
		$this->assertFalse(class_exists('Stub_Mephex_App_AutoLoader_PrefixA4', false));
		$this->assertTrue(class_exists('Stub_Mephex_App_AutoLoader_PrefixA4', true));
		
		$this->_auto_loader->unregisterSpl();
		
		$this->assertFalse(class_exists('Stub_Mephex_App_AutoLoader_PrefixA5', false));
		$this->assertFalse(class_exists('Stub_Mephex_App_AutoLoader_PrefixA5', true));
	}
}