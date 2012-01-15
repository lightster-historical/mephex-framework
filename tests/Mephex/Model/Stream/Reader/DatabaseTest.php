<?php



class Mephex_Model_Stream_Reader_DatabaseTest
extends Mephex_Test_TestCase
{
	protected $_connection;
	protected $_table_set;
	protected $_reader;
	
	
	
	public function setUp()
	{
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection(
			new Stub_Mephex_Db_Sql_Base_Credential(
				new Mephex_Db_Sql_Base_Quoter_Mysql()
			)
		);
		$this->_table_set	= new Mephex_Db_TableSet('prefix_', '_suffix');
		$this->_reader		= new Stub_Mephex_Model_Stream_Reader_Database($this->_connection, $this->_table_set);
	}
	
	
	
	public function testDatabaseReaderIsStreamReader()
	{
		$this->assertTrue($this->_reader instanceof Mephex_Model_Stream_Reader);
	}
	
	
	
	public function testConnectionGetterReturnsTheSameConnectionPassedToTheConstructor()
	{
		$this->assertTrue($this->_connection === $this->_reader->getConnection());
	}
	
	
	
	public function testTableSetIsOptionalAndDefaultsToEmptyTableSet()
	{
		$this->_reader	= new Stub_Mephex_Model_Stream_Reader_Database($this->_connection);
		$this->assertTrue($this->_reader->getTableSet() instanceof Mephex_Db_TableSet);
		$this->assertEquals(
			'test', 
			$this->_reader->getTableSet()->get('test')
		);
	}
	
	
	
	public function testTableSetGetterReturnsTheSameTableSetPassedToTheConstructor()
	{
		$this->assertTrue($this->_table_set === $this->_reader->getTableSet());
		$this->assertEquals(
			'prefix_test_suffix', 
			$this->_reader->getTableSet()->get('test')
		);
	}
	
	
	
	public function testTableGetterReturnsTableNameFromTableSet()
	{
		$this->assertEquals(
			'prefix_abc123_suffix', 
			$this->_reader->getTable('abc123')
		);
	}
}  