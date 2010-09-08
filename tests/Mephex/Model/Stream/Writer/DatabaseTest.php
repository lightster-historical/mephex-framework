<?php



class Mephex_Model_Stream_Writer_DatabaseTest
extends Mephex_Test_TestCase
{
	protected $_connection;
	protected $_writer;
	
	
	
	public function setUp()
	{
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection();
		$this->_writer		= new Stub_Mephex_Model_Stream_Writer_Database($this->_connection);
	}
	
	
	
	public function testDatabaseWriterIsStreamWriter()
	{
		$this->assertTrue($this->_writer instanceof Mephex_Model_Stream_Writer);
	}
	
	
	
	public function testConnectionGetterReturnsTheSameConnectionPassedToTheConstructor()
	{
		$this->assertTrue($this->_connection === $this->_writer->getConnection());
	}
}  