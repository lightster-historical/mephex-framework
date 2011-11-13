<?php



class Mephex_Db_ConnectionManager_Exception_UnregisteredConnectionTest
extends Mephex_Test_TestCase
{
	protected $_manager;
	protected $_name;

	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_manager		= new Stub_Mephex_Db_ConnectionManager(array());
		$this->_name		= '';

		$this->_exception	= new Mephex_Db_ConnectionManager_Exception_UnregisteredConnection(
			$this->_manager,
			$this->_name
		);
	}
	
	

	/**
	 * @expectedException Mephex_Db_ConnectionManager_Exception_UnregisteredConnection
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Db_ConnectionManager_Exception_UnregisteredConnection::__construct 
	 * @covers Mephex_Db_ConnectionManager_Exception_UnregisteredConnection::getConnectionManager 
	 */
	public function testConnectionManagerCanBeRetrieved()
	{
		$this->assertTrue(
			$this->_manager
			===
			$this->_exception->getConnectionManager()
		);
	}



	/**
	 * @covers Mephex_Db_ConnectionManager_Exception_UnregisteredConnection::__construct 
	 * @covers Mephex_Db_ConnectionManager_Exception_UnregisteredConnection::getName 
	 */
	public function testNameCanBeRetrieved()
	{
		$this->assertEquals($this->_name, $this->_exception->getName());
	}
}