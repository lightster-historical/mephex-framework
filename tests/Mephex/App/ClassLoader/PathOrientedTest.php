<?php



class Mephex_App_ClassLoader_PathOrientedTest
extends Mephex_Test_TestCase
{
	public function testNonPrefixedClassLoaderCanLoadAnyClass()
	{
		$class_loader	= new Mephex_App_ClassLoader_PathOriented();
		
		$this->assertFalse(class_exists('Stub_Mephex_App_ClassLoader_PathOriented_NonPrefixed', false));
		$this->assertTrue($class_loader->loadClass('Stub_Mephex_App_ClassLoader_PathOriented_NonPrefixed'));
		$this->assertTrue(class_exists('Stub_Mephex_App_ClassLoader_PathOriented_NonPrefixed', false));
	}
	
	
	
	public function testPrefixedClassLoaderCanLoadPrefixedClass()
	{
		$class_loader	= new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_ClassLoader_PathOriented_Allowed');
		
		$this->assertFalse(class_exists('Stub_Mephex_App_ClassLoader_PathOriented_AllowedPrefixed', false));
		$this->assertTrue($class_loader->loadClass('Stub_Mephex_App_ClassLoader_PathOriented_AllowedPrefixed'));
		$this->assertTrue(class_exists('Stub_Mephex_App_ClassLoader_PathOriented_AllowedPrefixed', false));
	}
	
	
	
	public function testPrefixedClassLoaderCannotLoadNonPrefixedClass()
	{
		$class_loader	= new Mephex_App_ClassLoader_PathOriented('Stub_Mephex_App_ClassLoader_PathOriented_Allowed');
		
		$this->assertFalse(class_exists('Stub_Mephex_App_ClassLoader_PathOriented_DisallowedPrefixed', false));
		$this->assertFalse($class_loader->loadClass('Stub_Mephex_App_ClassLoader_PathOriented_DisallowedPrefixed'));
		$this->assertFalse(class_exists('Stub_Mephex_App_ClassLoader_PathOriented_DisallowedPrefixed', false));
	}
	
	
	
	public function testAttemptingToLoadANonExistantClassDoesNotCauseAFatalError()
	{
		$class_loader	= new Mephex_App_ClassLoader_PathOriented();
		
		$this->assertFalse($class_loader->loadClass('Stub_Mephex_App_ClassLoader_PathOriented_NonExistant'));
	}
}