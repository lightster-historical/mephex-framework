<?php



class Mephex_Test_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_SqliteTest
extends Mephex_Test_TestCase
{
	protected $_tmp_path;
	protected $_group;

	protected $_config;

	protected $_details_factory;
	
	
	
	public function setUp()
	{
		parent::setUp();

		$this->_tmp_path	= PATH_TEST_ROOT . "/tmp";
		$this->_group		= 'database';

		$this->_config	= new Mephex_Config_OptionSet();
		$this->_config->addLoader(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'config.ini'
			)
		);
		$this->_config->set('database', 'sqlite.tmp_copier', new Mephex_Test_TmpFileCopier($this->_tmp_path));

		$this->_details_factory	= new Mephex_Test_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite(
			$this->_config,
			$this->_group
		);
	}



	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite::getCredentialDetails
	 */
	public function testOriginalDatabaseIsRememberedAsConfigOption()
	{
		$credential	= $this->_details_factory->getCredentialDetails('sqlite');
		$this->assertEquals(
			PATH_TEST_ROOT . "/dbs/basic.sqlite3",
			$this->_config->get('database', 'sqlite.original_database')
		); 
	}
	
	
	
	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite::getCredentialDetails
	 */
	public function testDatabaseConfigOptionIsUpdatedToPathOfCopiedDatabase()
	{
		$credential	= $this->_details_factory->getCredentialDetails('sqlite');
		$this->assertNotEquals(
			PATH_TEST_ROOT . "/dbs/basic.sqlite3",
			$this->_config->get('database', 'sqlite.database')
		); 
		$this->assertEquals(
			$this->_tmp_path,
			substr($this->_config->get('database', 'sqlite.database'), 0, strlen($this->_tmp_path))
		); 
	}
	
	
	
	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite::getCredentialDetails
	 */
	public function testCopyOfDatabaseIsUsed()
	{
		$credential	= $this->_details_factory->getCredentialDetails('sqlite');
		$this->assertEquals(
			$credential->getDataSourceName(),
			'sqlite:' . $this->_config->get('database', 'sqlite.database')
		);
	}
}  