<?php



class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_SqliteTest
extends Mephex_Test_TestCase
{
	protected $_config;
	protected $_group;

	protected $_details_factory;
	
	
	
	public function setUp()
	{
		parent::setUp();

		$this->_config	= new Mephex_Config_OptionSet();
		$this->_group	= 'db_group';

		$this->_details_factory	= new Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite(
			$this->_config,
			$this->_group
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite
	 */
	public function testFactoryIsAConfigurableCredentialDetailsFactory()
	{
		$this->assertInstanceOf(
			'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable',
			$this->_details_factory
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite::getCredentialDetails
	 * @expectedException Mephex_Config_OptionSet_Exception_UnknownKey
	 */
	public function testAnExceptionIsThrownIfDatabaseOptionIsNotFound()
	{
		$this->_details_factory->getCredentialDetails('conn2');
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite::getCredentialDetails
	 */
	public function testDatabaseCanBeUsedToCreateACredential()
	{
		$this->_config->set($this->_group, 'conn4.database', 'some/path/to/db.sqlite3');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals(
			'sqlite:some/path/to/db.sqlite3',
			$credential->getDataSourceName()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite::getQuoter
	 */
	public function testQuoterIsASqliteQuoter()
	{
		$this->assertInstanceOf(
			'Mephex_Db_Sql_Base_Quoter_Sqlite',
			$this->_details_factory->getQuoter('conn5')
		);
	}
}  