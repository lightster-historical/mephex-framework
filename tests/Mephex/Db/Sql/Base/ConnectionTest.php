<?php



class Mephex_Db_Sql_Base_ConnectionTest
extends Mephex_Test_TestCase
{
	protected $_connection	= null;
	
	
	
	public function setUp()
	{	
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection();
	}
	
	
	
	public function testPreparedSettingIsNativeByDefault()
	{
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE, 
			$this->_connection->getPreparedSetting()
		);
	}
	
	
	
	public function testPreparedSettingCanBeSetToOff()
	{
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_OFF, 
			$this->_connection->getPreparedSetting()
		);
	}
	
	
	
	public function testPreparedSettingCanBeSetToEmulated()
	{
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED, 
			$this->_connection->getPreparedSetting()
		);
	}
	
	
	
	public function testPreparedSettingCanBeSetToNative()
	{
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE, 
			$this->_connection->getPreparedSetting()
		);
	}
}  