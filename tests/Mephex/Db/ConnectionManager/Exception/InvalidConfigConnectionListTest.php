<?php



class Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionListTest
extends Mephex_Test_TestCase
{
	protected $_config;

	protected $_manager;
	protected $_group;
	protected $_option;
	protected $_value;

	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_config		= new Mephex_Config_OptionSet();

		$this->_manager		= new Stub_Mephex_Db_ConnectionManager_Configurable(
			$this->_config
		);
		$this->_group		= 'mephex';
		$this->_option		= 'database.connections';
		$this->_value		= 'non-array';

		$this->_exception	= new Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList(
			$this->_manager,
			$this->_group,
			$this->_option,
			$this->_value
		);
	}
	
	

	/**
	 * @expectedException Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::__construct 
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::getConnectionManager 
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
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::__construct 
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::getGroup 
	 */
	public function testGroupCanBeRetrieved()
	{
		$this->assertEquals($this->_group, $this->_exception->getGroup());
	}



	/**
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::__construct 
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::getOption 
	 */
	public function testOptionCanBeRetrieved()
	{
		$this->assertEquals($this->_option, $this->_exception->getOption());
	}



	/**
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::__construct 
	 * @covers Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList::getValue 
	 */
	public function testValueCanBeRetrieved()
	{
		$this->assertEquals($this->_value, $this->_exception->getValue());
	}
}