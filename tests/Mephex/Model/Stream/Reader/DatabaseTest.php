<?php



class Mephex_Model_Stream_Reader_DatabaseTest
extends Mephex_Test_TestCase
{
	protected $_connection;
	protected $_reader;
	
	
	
	public function setUp()
	{
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection();
		$this->_reader		= new Stub_Mephex_Model_Stream_Reader_Database($this->_connection);
	}
	
	
	
	public function testConnectionGetterReturnsTheSameConnectionPassedToTheConstructor()
	{
		$this->assertTrue($this->_connection === $this->_reader->getConnection());
	}
}  