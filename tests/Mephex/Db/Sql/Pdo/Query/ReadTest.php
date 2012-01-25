<?php



class Mephex_Db_Sql_Pdo_Query_ReadTest
extends Mephex_Test_TestCase
{
	public function setUp()
	{
		parent::setUp();

		$db_rw		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$this->_write_details	= new Mephex_Db_Sql_Pdo_CredentialDetails("sqlite:{$db_rw}");
		$this->_read_details	= new Mephex_Db_Sql_Pdo_CredentialDetails("sqlite:{$db_rw}");
		$this->_credential		= new Mephex_Db_Sql_Pdo_Credential(
			new Mephex_Db_Sql_Base_Quoter_Sqlite(),
			$this->_write_details,
			$this->_read_details
		);
		$this->_connection		= new Stub_Mephex_Db_Sql_Pdo_Connection($this->_credential);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Query_Read::getPdoConnection
	 */
	public function testPdoConnectionReturnedIsReadConnection()
	{
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$this->_connection, 
			'SELECT ...', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_OFF
		);
		$this->assertSame(
			$this->_connection->getReadConnection(),
			$query->getPdoConnection()
		);
	}
}