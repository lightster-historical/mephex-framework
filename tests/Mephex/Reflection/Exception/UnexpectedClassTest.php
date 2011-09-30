<?php


 
class Mephex_Reflection_Exception_UnexpectedClassTest
extends Mephex_Test_TestCase
{
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_exception	
			= new Mephex_Reflection_Exception_UnexpectedClass(
				'expected_class', 'other_class'
			);
	}
	
	
	
	/**
	 * @expectedException Mephex_Reflection_Exception_UnexpectedClass
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Reflection_Exception_UnexpectedClass::__construct 
	 * @covers Mephex_Reflection_Exception_UnexpectedClass::getExpectedClass 
	 */
	public function testExpectedClassCanBeRetrieved()
	{
		$this->assertEquals('expected_class', $this->_exception->getExpectedClass());
	}



	/**
	 * @covers Mephex_Reflection_Exception_UnexpectedClass::__construct 
	 * @covers Mephex_Reflection_Exception_UnexpectedClass::getPassedClass 
	 */
	public function testPassedClassCanBeRetrieved()
	{
		$this->assertEquals('other_class', $this->_exception->getPassedClass());
	}
}