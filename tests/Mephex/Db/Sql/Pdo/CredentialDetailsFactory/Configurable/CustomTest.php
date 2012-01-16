<?php



class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_CustomTest
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

		$this->_details_factory	= new Stub_Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom(
			$this->_config,
			$this->_group
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom
	 */
	public function testFactoryIsAConfigurableCredentialDetailsFactory()
	{
		$this->assertInstanceOf(
			'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable',
			$this->_details_factory
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getCredentialDetails
	 * @expectedException Mephex_Config_OptionSet_Exception_UnknownKey
	 */
	public function testAnExceptionIsThrownIfDsnOptionIsNotFound()
	{
		$this->_details_factory->getCredentialDetails('conn2');
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getCredentialDetails
	 */
	public function testDsnCanBeUsedToCreateACredential()
	{
		$this->_config->set($this->_group, 'conn4.dsn', 'custom://dsn/db');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals(
			'custom://dsn/db',
			$credential->getDataSourceName()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getCredentialDetails
	 */
	public function testUsernameIsIncludedInCredentialIfProvided()
	{
		$this->_config->set($this->_group, 'conn4.dsn', 'custom://dsn/db');
		$this->_config->set($this->_group, 'conn4.username', 'username4');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals('username4', $credential->getUsername());
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getCredentialDetails
	 */
	public function testPasswordIsIncludedInCredentialIfProvided()
	{
		$this->_config->set($this->_group, 'conn4.dsn', 'custom://dsn/db');
		$this->_config->set($this->_group, 'conn4.password', 'password4');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals('password4', $credential->getPassword());
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getQuoterClassNames
	 */
	public function testQuoterClassNamesAreAsExpected()
	{
		$this->assertEquals(
			array(
				'Mephex_Db_Sql_Base_Quoter_SomeDbms',
				'SomeDbms',
			),
			$this->_details_factory->getQuoterClassNames('SomeDbms')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getQuoterClassName
	 */
	public function testQuoterClassNameCanBeDetermined()
	{
		$this->assertEquals(
			'Mephex_Db_Sql_Base_Quoter_Mysql',
			$this->_details_factory->getQuoterClassName('Mysql')
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getQuoterClassName
	 * @expectedException Mephex_Db_Sql_Pdo_Exception_UnknownQuoter
	 */
	public function testExceptionIsThrownIfAnUnknownQuoterNameIsRequested()
	{
		$this->_details_factory->getQuoterClassName('Unknown');
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getQuoter
	 */
	public function testQuoterCanBeDeterminedUsingShortName()
	{
		$this->_config->set($this->_group, 'conn5.dsn', 'custom://dsn/db');
		$this->_config->set($this->_group, 'conn5.quoter', 'Mysql');

		$this->assertInstanceOf(
			'Mephex_Db_Sql_Base_Quoter_Mysql',
			$this->_details_factory->getQuoter('conn5')
		);
	}
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom::getQuoter
	 */
	public function testQuoterCanBeDeterminedUsingClassName()
	{
		$this->_config->set($this->_group, 'conn5.dsn', 'custom://dsn/db');
		$this->_config->set($this->_group, 'conn5.quoter', 'Mephex_Db_Sql_Base_Quoter_Sqlite');

		$this->assertInstanceOf(
			'Mephex_Db_Sql_Base_Quoter_Sqlite',
			$this->_details_factory->getQuoter('conn5')
		);
	}
}  