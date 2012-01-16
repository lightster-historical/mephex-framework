<?php



class Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest
extends Mephex_Test_TestCase
{
	protected $_config;
	protected $_group;

	protected $_credential_factory;

	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_group		= 'some_group';
		$this->_config		= new Mephex_Config_OptionSet();

		$this->_credential_factory	= new Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Configurable(
			$this->_config,
			$this->_group
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredentialFactoryClassNames
	 */
	public function testCredentialFactoryClassNamesAreAsExpected()
	{
		$this->assertEquals(
			array(
				'Mephex_Db_Sql_Pdo_CredentialFactory_SomeDbms',
				'SomeDbms',
			),
			$this->_credential_factory->getCredentialFactoryClassNames('SomeDbms')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredentialFactoryClassName
	 */
	public function testCredentialFactoryClassNameCanBeDetermined()
	{
		$this->assertEquals(
			'Mephex_Db_Sql_Pdo_CredentialFactory_Mysql',
			$this->_credential_factory->getCredentialFactoryClassName('Mysql')
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredentialFactoryClassName
	 * @expectedException Mephex_Db_Sql_Pdo_Exception_UnknownDbms
	 */
	public function testExceptionIsThrownIfAnUnknownDbmsIsRequested()
	{
		$this->_credential_factory->getCredentialFactoryClassName('Unknown');
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testCredentialIsGenerated()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.dsn",
			'custom://dsn/db_generic'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_Credential', $credential);
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testWriteCredentialIsGeneratedWithReadWriteSetting()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.write.dsn",
			'custom://dsn/db_write'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.read.dsn",
			'custom://dsn/db_read'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertEquals(
			'custom://dsn/db_write',
			$credential->getWriteCredential()->getDataSourceName()
		);
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testReadCredentialIsGeneratedWithReadWriteSetting()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.write.dsn",
			'custom://dsn/db_write'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.read.dsn",
			'custom://dsn/db_read'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertEquals(
			'custom://dsn/db_read',
			$credential->getReadCredential()->getDataSourceName()
		);
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testWriteCredentialIsGeneratedWithOnlyWriteSetting()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.write.dsn",
			'custom://dsn/db_write'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertEquals(
			'custom://dsn/db_write',
			$credential->getWriteCredential()->getDataSourceName()
		);
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testReadCredentialIsSameAsWriteCredentialWhenOnlyWriteSettingExists()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.write.dsn",
			'custom://dsn/db_write'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertSame(
			$credential->getWriteCredential(),
			$credential->getReadCredential()
		);
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testWriteCredentialIsGeneratedWithOnlyGenericConfigOption()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.dsn",
			'custom://dsn/db_generic'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertEquals(
			'custom://dsn/db_generic',
			$credential->getWriteCredential()->getDataSourceName()
		);
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testReadCredentialIsSameAsWriteCredentialWithGnericConfigOption()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.dsn",
			'custom://dsn/db_generic'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertSame(
			$credential->getWriteCredential(),
			$credential->getReadCredential()
		);
	}
}