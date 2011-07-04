<?php



class Mephex_App_ClassLoaderTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_App_ClassLoader::__construct
	 */
	public function testClassLoaderCanBeInstantiated()
	{
		$class_loader	= new Stub_Mephex_App_ClassLoader();	
	}
	
	
	
	/**
	 * @covers Mephex_App_ClassLoader::includeExists
	 */
	public function testIncludeExistsFindsPathsInIncludePath()
	{
		$class_loader	= new Stub_Mephex_App_ClassLoader();
		
		$this->assertTrue($class_loader->includeExists('Mephex/App/ClassLoader.php'));
		$this->assertTrue($class_loader->includeExists('Stub/Mephex/App/ClassLoader.php'));
	}
	
	
	
	/**
	 * @covers Mephex_App_ClassLoader::includeExists
	 */
	public function testIncludeExistsDoesNotFindPathsOutsideIncludePath()
	{
		$class_loader	= new Stub_Mephex_App_ClassLoader();
		
		$this->assertFalse($class_loader->includeExists('ClassLoader.php'));
	}

	
	
	/**
	 * @covers Mephex_App_ClassLoader::includeExists
	 */
	public function testIncludeExistsDoesNotCheckIncludePathForAbsolutePaths()
	{
		$class_loader	= new Stub_Mephex_App_ClassLoader();
		
		$this->assertFalse($class_loader->includeExists('/Mephex/App/ClassLoader.php'));
	}
}