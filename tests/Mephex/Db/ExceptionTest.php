<?php



class Mephex_Db_ExceptionTest
extends Mephex_Test_TestCase
{
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_exception	= new Mephex_Db_Exception();
	}
	
	

	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}
}