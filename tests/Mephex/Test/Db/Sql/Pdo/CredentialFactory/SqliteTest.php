<?php



class Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite_Test
extends Mephex_Test_TestCase
{
	protected $_credential_factory = null;
	
	
	
	/**
	 * Deallocates any resources created by a test case.
	 */
	protected function tearDown()
	{
		$this->_credential_factory	= null;
	} 
	
	
	
	/**
	 * Lazy-loads the credential factory.
	 * 
	 * @return Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite
	 */
	public function getCredentialFactory()
	{
		if(null === $this->_credential_factory)
		{ 
			$this->_credential_factory = new Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite();
		}
		
		return $this->_credential_factory;
	}
	
	
	
	public function testOriginalDatabaseIsRememberedAsConfigOption()
	{
		$config	= new Mephex_Config_OptionSet();
		$config->addLoader(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'config.ini'
			)
		);
		
		$tmp_path	= PATH_TEST_ROOT . "/tmp";
		$config->set('database', 'sqlite.tmp_copier', new Mephex_Test_TmpFileCopier($tmp_path));

		$credential	= $this->getCredentialFactory()->loadFromConfig(
			$config, 
			'database', 
			'sqlite'
		);
		$this->assertEquals(
			PATH_TEST_ROOT . "/dbs/basic.sqlite3",
			$config->get('database', 'sqlite.original_database')
		); 
	}
	
	
	
	public function testDatabaseConfigOptionIsUpdatedToPathOfCopiedDatabase()
	{
		$config	= new Mephex_Config_OptionSet();
		$config->addLoader(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'config.ini'
			)
		);
		
		$tmp_path	= PATH_TEST_ROOT . "/tmp";
		$config->set('database', 'sqlite.tmp_copier', new Mephex_Test_TmpFileCopier($tmp_path));

		$credential	= $this->getCredentialFactory()->loadFromConfig(
			$config, 
			'database', 
			'sqlite'
		);
		$this->assertNotEquals(
			PATH_TEST_ROOT . "/dbs/basic.sqlite3",
			$config->get('database', 'sqlite.database')
		); 
		$this->assertEquals(
			$tmp_path,
			substr($config->get('database', 'sqlite.database'), 0, strlen($tmp_path))
		); 
	}
	
	
	
	public function testCopyOfDatabaseIsUsed()
	{
		$config	= new Mephex_Config_OptionSet();
		$config->addLoader(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'config.ini'
			)
		);
		
		$tmp_path	= PATH_TEST_ROOT . "/tmp";
		$config->set('database', 'sqlite.tmp_copier', new Mephex_Test_TmpFileCopier($tmp_path));

		$credential	= $this->getCredentialFactory()->loadFromConfig(
			$config,
			'database', 
			'sqlite'
		);
		$this->assertEquals(
			$credential->getDataSourceName(),
			'sqlite:' . $config->get('database', 'sqlite.database')
		);
	}
}  