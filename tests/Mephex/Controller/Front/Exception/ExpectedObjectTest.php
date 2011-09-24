<?php


 
class Mephex_Controller_Front_Exception_ExpectedObjectTest
extends Mephex_Test_TestCase
{
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_exception	
			= new Mephex_Controller_Front_Exception_ExpectedObject(
				'expected_class',
				array('some_value')
			);
	}
	
	
	
	/**
	 * @expectedException Mephex_Controller_Front_Exception_ExpectedObject
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Controller_Front_Exception_ExpectedObject::__construct 
	 * @covers Mephex_Controller_Front_Exception_ExpectedObject::getExpectedClass 
	 */
	public function testExpectedClassCanBeRetrieved()
	{
		$this->assertEquals('expected_class', $this->_exception->getExpectedClass());
	}



	/**
	 * @covers Mephex_Controller_Front_Exception_ExpectedObject::__construct 
	 * @covers Mephex_Controller_Front_Exception_ExpectedObject::getPassedValue 
	 */
	public function testPassedValueCanBeRetrieved()
	{
		$this->assertEquals(array('some_value'), $this->_exception->getPassedValue());
	}
}