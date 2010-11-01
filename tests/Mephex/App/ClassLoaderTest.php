<?php



class Mephex_App_ClassLoaderTest
extends Mephex_Test_TestCase
{
	public function testIncludeExistsFindsPathsInIncludePath()
	{
		$class_loader	= new Stub_Mephex_App_ClassLoader();
		
		$this->assertTrue($class_loader->includeExists('Mephex/App/ClassLoader.php'));
		$this->assertTrue($class_loader->includeExists('Stub/Mephex/App/ClassLoader.php'));
	}
	
	
	
	public function testIncludeExistsDoesNotFindPathsOutsideIncludePath()
	{
		$class_loader	= new Stub_Mephex_App_ClassLoader();
		
		$this->assertFalse($class_loader->includeExists('ClassLoader.php'));
	}

	
	
	public function testIncludeExistsDoesNotCheckIncludePathForAbsolutePaths()
	{
		$class_loader	= new Stub_Mephex_App_ClassLoader();
		
		$this->assertFalse($class_loader->includeExists('/Mephex/App/ClassLoader.php'));
	}
}