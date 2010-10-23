<?php



class Mephex_Model_Stream_Writer_DatabaseTest
extends Mephex_Test_TestCase
{
	protected $_connection;
	protected $_table_set;
	protected $_writer;
	
	
	
	public function setUp()
	{
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection();
		$this->_table_set	= new Mephex_Db_TableSet('prefix_', '_suffix');
		$this->_writer		= new Stub_Mephex_Model_Stream_Writer_Database($this->_connection, $this->_table_set);
	}
	
	
	
	public function testDatabaseWriterIsStreamWriter()
	{
		$this->assertTrue($this->_writer instanceof Mephex_Model_Stream_Writer);
	}
	
	
	
	public function testConnectionGetterReturnsTheSameConnectionPassedToTheConstructor()
	{
		$this->assertTrue($this->_connection === $this->_writer->getConnection());
	}
	
	
	
	public function testTableSetIsOptionalAndDefaultsToEmptyTableSet()
	{
		$this->_writer	= new Stub_Mephex_Model_Stream_Writer_Database($this->_connection);
		$this->assertTrue($this->_writer->getTableSet() instanceof Mephex_Db_TableSet);
		$this->assertEquals(
			'test', 
			$this->_writer->getTableSet()->get('test')
		);
	}
	
	
	
	public function testTableSetGetterReturnsTheSameTableSetPassedToTheConstructor()
	{
		$this->assertTrue($this->_table_set === $this->_writer->getTableSet());
		$this->assertEquals(
			'prefix_test_suffix', 
			$this->_writer->getTableSet()->get('test')
		);
	}
	
	
	
	public function testTableGetterReturnsTableNameFromTableSet()
	{
		$this->assertEquals(
			'prefix_abc123_suffix', 
			$this->_writer->getTable('abc123')
		);
	}
}  