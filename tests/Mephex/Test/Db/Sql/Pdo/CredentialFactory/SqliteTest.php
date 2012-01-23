<?php



class Mephex_Test_Db_Sql_Pdo_CredentialFactory_SqliteTest
extends Mephex_Test_TestCase
{
	protected $_tmp_path;
	protected $_tmp_copier;

	protected $_factory;
	
	
	
	public function setUp()
	{
		parent::setUp();

		$this->_tmp_path	= PATH_TEST_ROOT . "/tmp";
		$this->_tmp_copier	= new Mephex_Test_TmpFileCopier($this->_tmp_path);

		$this->_factory		= new Stub_Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite(
			$this->_tmp_copier
		);
	}



	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite::__construct
	 */
	public function testClassIsInstantiable()
	{
		$this->assertInstanceOf(
			'Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite',
			$this->_factory
		);
	}



	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite::__construct
	 * @depends testClassIsInstantiable
	 */
	public function testTmpCopierIsSetByConstructor()
	{
		$this->assertAttributeSame(
			$this->_tmp_copier,
			'_tmp_copier',
			$this->_factory
		);
	}



	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite::getCredentialDetails
	 * @depends testClassIsInstantiable
	 */
	public function testNameIsUsedAsFilePathWhenGeneratingCredentialDetails()
	{
		$this->assertEquals(
			'sqlite:some/path/name.sqlite',
			$this->_factory->getCredentialDetails('some/path/name.sqlite')
				->getDataSourceName()
		);
	}



	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite::getCredential
	 * @depends testClassIsInstantiable
	 */
	public function testReadAndWriteCredentialDetailsAreSame()
	{
		$credential			= $this->_factory->getCredential(
			PATH_TEST_ROOT . "/dbs/basic.sqlite3"
		);
		$write_credential	= $credential->getWriteCredential();
		$read_credential	= $credential->getReadCredential();

		$this->assertSame(
			$read_credential,
			$write_credential
		);
	}



	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite::getCredential
	 * @depends testClassIsInstantiable
	 */
	public function testQuoterIsSqliteQuoter()
	{
		$credential	= $this->_factory->getCredential(
			PATH_TEST_ROOT . "/dbs/basic.sqlite3"
		);
		$this->assertInstanceOf(
			'Mephex_Db_Sql_Base_Quoter_Sqlite',
			$credential->getQuoter()
		);
	}



	/**
	 * @covers Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite::getCredential
	 * @depends testClassIsInstantiable
	 */
	public function testPathUsedForDsnIsDifferentThanOriginalPath()
	{
		$original_path		= PATH_TEST_ROOT . "/dbs/basic.sqlite3";
		$credential			= $this->_factory->getCredential(
			$original_path
		);
		$read_credential	= $credential->getReadCredential();
		$new_path			= substr($read_credential->getDataSourceName(), 7);

		$this->assertNotEquals(
			realpath($original_path),
			realpath($new_path)
		);
	}
}