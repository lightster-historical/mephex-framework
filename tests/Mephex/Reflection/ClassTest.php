<?php



class Mephex_Reflection_ClassTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_Reflection_Class::__construct
	 * @expectedException Mephex_Reflection_Exception_NonexistentClass
	 */
	public function testNonexistentExpectedClassThrowsException()
	{
		$class	= new Mephex_Reflection_Class('not_a_class');
	}



	/**
	 * @covers Mephex_Reflection_Class::checkObjectType
	 * @expectedException Mephex_Reflection_Exception_ExpectedObject
	 */
	public function testNonObjectFailsObjectInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Controller_Action_Base');
		$class->checkObjectType('non_object');
	}



	/**
	 * @covers Mephex_Reflection_Class::checkObjectType
	 * @expectedException Mephex_Reflection_Exception_ExpectedObject
	 */
	public function testUnexpectedObjectTypeFailsObjectInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Controller_Action_Base');
		$class->checkObjectType($this);
	}



	/**
	 * @covers Mephex_Reflection_Class::checkObjectType
	 */
	public function testObjectCanPassObjectInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Reflection_Class');
		$this->assertTrue($class === $class->checkObjectType($class));
	}



	/**
	 * @covers Mephex_Reflection_Class::checkClassInheritance
	 * @expectedException Mephex_Reflection_Exception_NonexistentClass
	 */
	public function testNonexistentPassedClassFailsClassInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Controller_Action_Base');
		$class->checkClassInheritance('not_a_class');
	}



	/**
	 * @covers Mephex_Reflection_Class::checkClassInheritance
	 * @expectedException Mephex_Reflection_Exception_UnexpectedClass
	 */
	public function testUnexpectedClassTypeFailsClassInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Controller_Front_Base');
		$class->checkClassInheritance('Mephex_Controller_Action_Base');
	}



	/**
	 * @covers Mephex_Reflection_Class::checkClassInheritance
	 * @expectedException Mephex_Reflection_Exception_UnexpectedClass
	 */
	public function testUnexpectedClassTypeFailsInterfaceClassInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Controller_Front');
		$class->checkClassInheritance('Mephex_Controller_Action_Base');
	}



	/**
	 * @covers Mephex_Reflection_Class::checkClassInheritance
	 */
	public function testClassCanPassClassInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Controller_Front_Base');
		$this->assertEquals(
			'Stub_Mephex_Controller_Front_Base',
			$class->checkClassInheritance('Stub_Mephex_Controller_Front_Base')
		);
	}



	/**
	 * @covers Mephex_Reflection_Class::checkClassInheritance
	 */
	public function testClassCanPassInterfaceClassInheritanceCheck()
	{
		$class	= new Mephex_Reflection_Class('Mephex_Controller_Front');
		$this->assertEquals(
			'Mephex_Controller_Front_Base',
			$class->checkClassInheritance('Mephex_Controller_Front_Base')
		);
	}
}