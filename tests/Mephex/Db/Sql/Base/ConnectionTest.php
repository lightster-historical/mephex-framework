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
	
	
	
	public function testInitializedQuoterIsABaseQuoterByDefault()
	{
		$this->assertTrue(
			$this->_connection->getQuoter()
			instanceof
			Mephex_Db_Sql_Base_Quoter
		);
	}
	
	
	
	public function testGeneratingAnInsertGeneratorIsPossible()
	{
		$this->assertTrue(
			$this->_connection->generateInsert(
				'test',
				array('a', 'b', 'c')
			)
			instanceof
			Mephex_Db_Sql_Base_Generator_Insert
		);
	}
	
	
	
	public function testGeneratingAnUpdateGeneratorIsPossible()
	{
		$this->assertTrue(
			$this->_connection->generateUpdate(
				'test',
				array('a', 'b', 'c'),
				array('x', 'y')
			)
			instanceof
			Mephex_Db_Sql_Base_Generator_Update
		);
	}
}  