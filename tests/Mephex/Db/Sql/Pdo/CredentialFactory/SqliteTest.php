<?php



class Mephex_Db_Sql_Pdo_CredentialFactory_SqliteTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	protected $_config;
	
	
	
	public function __construct()
	{	
		$this->_credential_factory	= new Mephex_Db_Sql_Pdo_CredentialFactory_Sqlite();
		$this->_config	= new Mephex_Config_OptionSet();
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnExceptionIsThrownIfDatabaseOptionIsNotFound()
	{
		$this->_credential_factory->loadFromConfig($this->_config, 'group2', 'conn2');
	}
	
	
	
	public function testDatabaseCanBeUsedToCreateACredential()
	{
		$this->_config->set('group3', 'conn3.database', 'some/path/to/db.sqlite3');
		
		$credential	= $this->_credential_factory->loadFromConfig(
			$this->_config, 'group3', 'conn3'
		);
		
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_Credential);
		$this->assertEquals('sqlite:some/path/to/db.sqlite3', $credential->getDataSourceName());
	}
}  