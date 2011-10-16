<?php



class Mephex_App_Arguments_Exception_UnknownKeyTest
extends Mephex_Test_TestCase
{
	protected $_arguments;
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_arguments	= new Mephex_App_Arguments();
		$this->_exception	= new Mephex_App_Arguments_Exception_UnknownKey(
			$this->_arguments, 'missing_key'
		);
	}
	
	

	/**
	 * @expectedException Mephex_App_Arguments_Exception_UnknownKey
	 */
	public function testUnknownKeyExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_App_Arguments_Exception_UnknownKey::__construct 
	 * @covers Mephex_App_Arguments_Exception_UnknownKey::getArguments 
	 */
	public function testCacheCanBeRetrieved()
	{
		$this->assertTrue($this->_arguments === $this->_exception->getArguments());
	}



	/**
	 * @covers Mephex_App_Arguments_Exception_UnknownKey::__construct 
	 * @covers Mephex_App_Arguments_Exception_UnknownKey::getKey 
	 */
	public function testKeyCanBeRetrieved()
	{
		$this->assertEquals('missing_key', $this->_exception->getKey());
	}
}