<?php



class Mephex_App_Class_Loader_PathOrientedTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_App_Class_Loader_PathOriented::loadClass
	 */
	public function testNonPrefixedClassLoaderCanLoadAnyClass()
	{
		$class_loader	= new Mephex_App_Class_Loader_PathOriented();
		
		$this->assertFalse(class_exists('Stub_Mephex_App_Class_Loader_PathOriented_NonPrefixed', false));
		$this->assertTrue($class_loader->loadClass('Stub_Mephex_App_Class_Loader_PathOriented_NonPrefixed'));
		$this->assertTrue(class_exists('Stub_Mephex_App_Class_Loader_PathOriented_NonPrefixed', false));
	}
	
	
	
	/**
	 * @covers Mephex_App_Class_Loader_PathOriented::__construct
	 * @covers Mephex_App_Class_Loader_PathOriented::loadClass
	 * @covers Mephex_App_Class_Loader_PathOriented::isPrefixRequirementMet
	 */
	public function testPrefixedClassLoaderCanLoadPrefixedClass()
	{
		$class_loader	= new Mephex_App_Class_Loader_PathOriented('Stub_Mephex_App_Class_Loader_PathOriented_Allowed');
		
		$this->assertFalse(class_exists('Stub_Mephex_App_Class_Loader_PathOriented_AllowedPrefixed', false));
		$this->assertTrue($class_loader->loadClass('Stub_Mephex_App_Class_Loader_PathOriented_AllowedPrefixed'));
		$this->assertTrue(class_exists('Stub_Mephex_App_Class_Loader_PathOriented_AllowedPrefixed', false));
	}
	
	
	
	/**
	 * @covers Mephex_App_Class_Loader_PathOriented::__construct
	 * @covers Mephex_App_Class_Loader_PathOriented::loadClass
	 * @covers Mephex_App_Class_Loader_PathOriented::isPrefixRequirementMet
	 */
	public function testPrefixedClassLoaderCannotLoadNonPrefixedClass()
	{
		$class_loader	= new Mephex_App_Class_Loader_PathOriented('Stub_Mephex_App_Class_Loader_PathOriented_Allowed');
		
		$this->assertFalse(class_exists('Stub_Mephex_App_Class_Loader_PathOriented_DisallowedPrefixed', false));
		$this->assertFalse($class_loader->loadClass('Stub_Mephex_App_Class_Loader_PathOriented_DisallowedPrefixed'));
		$this->assertFalse(class_exists('Stub_Mephex_App_Class_Loader_PathOriented_DisallowedPrefixed', false));
	}
	
	
	
	/**
	 * @covers Mephex_App_Class_Loader_PathOriented::loadClass
	 */
	public function testAttemptingToLoadANonExistantClassDoesNotCauseAFatalError()
	{
		$class_loader	= new Mephex_App_Class_Loader_PathOriented();
		
		$this->assertFalse($class_loader->loadClass('Stub_Mephex_App_Class_Loader_PathOriented_NonExistant'));
	}
}