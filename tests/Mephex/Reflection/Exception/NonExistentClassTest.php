<?php


 
class Mephex_Reflection_Exception_NonexistentClassTest
extends Mephex_Test_TestCase
{
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_exception	
			= new Mephex_Reflection_Exception_NonexistentClass(
				'missing_class'
			);
	}
	
	
	
	/**
	 * @expectedException Mephex_Reflection_Exception_NonexistentClass
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Reflection_Exception_NonexistentClass::__construct 
	 * @covers Mephex_Reflection_Exception_NonexistentClass::getClass 
	 */
	public function testClassCanBeRetrieved()
	{
		$this->assertEquals('missing_class', $this->_exception->getClass());
	}
}