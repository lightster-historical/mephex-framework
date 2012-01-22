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
				'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_SomeDbms',
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
			'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql',
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
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDetailsFactory
	 * @dataProvider providerDbmsTypes
	 */
	public function testDetailsFactoryCanBeGeneratedBasedOnConfigOption(
		$dbms, $class_name
	)
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			$dbms
		);
		$this->assertInstanceOf(
			$class_name,
			$this->_credential_factory->getDetailsFactory('conn_name')
		);
	}



	public function providerDbmsTypes()
	{
		return array(
			array(
				'Custom',
				'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom'
			),
			array(
				'Sqlite',
				'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite'
			),
			array(
				'Mysql',
				'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql'
			),
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDetailsFactory
	 */
	public function testDetailsFactoryIsPassedConfigOptionSet()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);

		$this->assertAttributeSame(
			$this->_config,
			'_config',
			$this->_credential_factory->getDetailsFactory('conn_name')
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDetailsFactory
	 */
	public function testDetailsFactoryIsPassedConfigGroup()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->assertAttributeEquals(
			$this->_group,
			'_group',
			$this->_credential_factory->getDetailsFactory('conn_name')
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDualCredential
	 */
	public function testDualCredentialIsGenerated()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.enable_dual",
			true
		);
		$this->_config->set(
			$this->_group,
			"conn_name.write.dsn",
			'custom://dsn/db_generic'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.read.dsn",
			'custom://dsn/db_generic'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_Credential', $credential);
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testDualCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDualCredential
	 */
	public function testWriteCredentialIsGeneratedWithDualCredentialEnabled()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.enable_dual",
			true
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
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testDualCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDualCredential
	 */
	public function testReadCredentialIsGeneratedWithDualCredentialEnabled()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.enable_dual",
			true
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
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testDualCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDualCredential
	 * @expectedException Mephex_Config_OptionSet_Exception_UnknownKey
	 */
	public function testExceptionIsThrownIfDualCredentialIsEnabledButReadCredentialIsMissing()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.enable_dual",
			true
		);
		$this->_config->set(
			$this->_group,
			"conn_name.write.dsn",
			'custom://dsn/db_write'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
	}



	/**
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testDualCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getDualCredential
	 * @expectedException Mephex_Config_OptionSet_Exception_UnknownKey
	 */
	public function testExceptionIsThrownIfDualCredentialIsEnabledButWriteCredentialIsMissing()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.enable_dual",
			true
		);
		$this->_config->set(
			$this->_group,
			"conn_name.read.dsn",
			'custom://dsn/db_write'
		);

		$credential	= $this->_credential_factory->getCredential('conn_name');
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getSingularCredential
	 */
	public function testSingularCredentialIsGenerated()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
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
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testSingularCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getSingularCredential
	 */
	public function testWriteCredentialIsGeneratedWithSingularCredential()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
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
	 * @depends Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest::testSingularCredentialIsGenerated
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getSingularCredential
	 */
	public function testReadCredentialIsSameAsWriteCredentialWithSingularCredential()
	{
		$this->_config->set(
			$this->_group,
			"conn_name.dbms",
			'Custom'
		);
		$this->_config->set(
			$this->_group,
			"conn_name.quoter",
			'Mysql'
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