<?php



class Mephex_Db_Sql_Pdo_CredentialFactory_ConfigurableTest
extends Mephex_Test_TestCase
{
	protected $_config;
	protected $_group;
	protected $_conn_name;

	protected $_credential_factory;

	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_group		= 'some_group';
		$this->_conn_name	= 'conn_name';

		$this->_config	= new Mephex_Config_OptionSet();
		$this->_config->set(
			$this->_group,
			"{$this->_conn_name}.dbms",
			'CustomDsn'
		);
		$this->_config->set(
			$this->_group,
			"{$this->_conn_name}.dsn",
			'custom://dsn/db'
		);

		$this->_credential_factory	= new Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Configurable(
			$this->_config,
			$this->_group
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredentialFactoryClassNames
	 */
	public function testCredentialFactoryClassNamesAreExpected()
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
		$credential	= $this->_credential_factory->getCredential($this->_conn_name);
		$this->assertTrue(
			$credential
			instanceof
			Mephex_Db_Sql_Pdo_CredentialDetails
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::__construct
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_Configurable::getCredential
	 */
	public function testCredentialIsGeneratedUsingCorrectFactory()
	{
		$credential	= $this->_credential_factory->getCredential($this->_conn_name);
		$this->assertEquals(
			'custom://dsn/db',
			$credential->getDataSourceName()
		);
	}
}