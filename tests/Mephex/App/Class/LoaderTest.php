<?php



class Mephex_App_Class_LoaderTest
extends Mephex_Test_TestCase
{
	protected $_class_loader;



	protected function setUp()
	{
		parent::setUp();

		$this->_class_loader	= new Stub_Mephex_App_Class_Loader();
	}




	/**
	 * @covers Mephex_App_Class_Loader::__construct
	 */
	public function testClassLoaderCanBeInstantiated()
	{
		$this->assertTrue(
			$this->_class_loader
			instanceof 
			Mephex_App_Class_Loader
		);
	}



	public function testDefaultIncludePathCanBeRetrieved()
	{
		$this->assertTrue(
			$this->_class_loader->getIncludePath()
			instanceof 
			Mephex_FileSystem_IncludePath
		);
	}



	public function testOtherIncludePathCanBeUsed()
	{
		$include_path	= new Mephex_FileSystem_IncludePath();
		$class_loader	= new Stub_Mephex_App_Class_Loader($include_path);

		$this->assertTrue(
			$include_path === $class_loader->getIncludePath()
		);
	}
}