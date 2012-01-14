<?php



class Mephex_Db_Sql_Pdo_CredentialFactory_CustomDsnTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	protected $_config;
	
	
	
	public function __construct()
	{	
		$this->_credential_factory	= new Mephex_Db_Sql_Pdo_CredentialFactory_CustomDsn();
		$this->_config	= new Mephex_Config_OptionSet();
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_CustomDsn::loadFromConfig
	 * @expectedException Mephex_Exception
	 */
	public function testAnExceptionIsThrownIfADsnIsNotFound()
	{	
		$this->_credential_factory->loadFromConfig($this->_config, 'group3', 'conn3');
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_CustomDsn::loadFromConfig
	 */
	public function testDsnCanBeUsedToCreateACredential()
	{
		$this->_config->set('group4', 'conn4.dsn', 'the://dsn/string');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_CredentialDetails);
		$this->assertEquals('the://dsn/string', $credential->getDataSourceName());
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_CustomDsn::loadFromConfig
	 */
	public function testUsernameIsIncludedInCredentialIfProvided()
	{
		$this->_config->set('group4', 'conn4.dsn', 'the://dsn/string');
		$this->_config->set('group4', 'conn4.username', 'username4');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_CredentialDetails);
		$this->assertEquals('username4', $credential->getUsername());
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialFactory_CustomDsn::loadFromConfig
	 */
	public function testPasswordIsIncludedInCredentialIfProvided()
	{
		$this->_config->set('group4', 'conn4.dsn', 'the://dsn/string');
		$this->_config->set('group4', 'conn4.password', 'password4');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_CredentialDetails);
		$this->assertEquals('password4', $credential->getPassword());
	}
}