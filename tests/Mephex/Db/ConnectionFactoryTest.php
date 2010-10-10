<?php



class Mephex_Db_ConnectionFactoryTest
extends Mephex_Test_TestCase
{
	protected $_connection_factory;
	protected $_config;
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_connection_factory	= new Mephex_Db_ConnectionFactory();
		$this->_config	= new Mephex_Config_OptionSet();
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testExceptionIsThrownIfDriverConfigOptionIsNotFound()
	{
		$this->_connection_factory->connectUsingConfig($this->_config, 'group0', 'conn0');
	}
	
	
	
	public function testDriverNameCanBeUsedToDetermineConnectionFactory()
	{
		$this->_config->set('group1', 'conn1.driver', 'Pdo');
		$this->_config->set('group1', 'conn1.dbms', 'Sqlite');
		$this->_config->set('group1', 'conn1.database', 'some_db.sqlite3');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group1', 'conn1'
		);
		
		$this->assertTrue(
			$connection instanceof Mephex_Db_Sql_Pdo_Connection
		);
	}
	
	
	
	public function testClassNameCanBeUsedToDetermineConnectionFactory()
	{
		$this->_config->set('group2', 'conn2.driver', 'Mephex_Db_Sql_Pdo_ConnectionFactory');
		$this->_config->set('group2', 'conn2.dbms', 'Sqlite');
		$this->_config->set('group2', 'conn2.database', 'some_db.sqlite3');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group2', 'conn2'
		);
		
		$this->assertTrue(
			$connection instanceof Mephex_Db_Sql_Pdo_Connection
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testExceptionIsThrownIfAnUnknownDriverIsUsed()
	{
		$this->_config->set('group3', 'conn3.driver', 'Unknown');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group3', 'conn3'
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testExceptionIsThrownIfReturnedDriverIsNotAConnectionFactory()
	{
		$this->_config->set('group4', 'conn4.driver', 'Mephex_Db_ConnectionFactoryTest');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group4', 'conn4'
		);
	}
}  