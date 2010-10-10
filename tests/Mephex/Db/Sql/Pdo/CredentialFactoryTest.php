<?php



class Mephex_Db_Sql_Pdo_CredentialFactoryTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	protected $_config;
	
	
	
	public function __construct()
	{	
		$this->_credential_factory	= new Mephex_Db_Sql_Pdo_CredentialFactory();
		$this->_config	= new Mephex_Config_OptionSet();
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testExceptionIsThrownIfDriverConfigOptionIsNotFound()
	{
		$this->_credential_factory->loadFromConfig($this->_config, 'group0', 'conn0');
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testExceptionIsThrownIfReturnedDbmsIsUnknown()
	{
		$this->_config->set('group1', 'conn1.dbms', 'unknown');
		
		$this->_credential_factory->loadFromConfig($this->_config, 'group1', 'conn1');
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testExceptionIsThrownIfReturnedDbmsIsNotACredentialFactory()
	{
		$this->_config->set('group1', 'conn1.dbms', 'Mephex_Db_Sql_Pdo_CredentialFactoryTest');
		
		$credential	= $this->_credential_factory->loadFromConfig(
			$this->_config, 'group1', 'conn1'
		);
	}
	
	
	
	public function testDbmsNameCanBeUsedToDetermineCredentialFactory()
	{
		$this->_config->set('group2', 'conn2.dbms', 'Mysql');
		$this->_config->set('group2', 'conn2.database', 'does_not_matter');
		$this->_config->set('group2', 'conn2.host', 'does_not_matter');
		
		$credential	= $this->_credential_factory->loadFromConfig(
			$this->_config, 'group2', 'conn2'
		);
		
		$this->assertTrue(
			$credential instanceof Mephex_Db_Sql_Pdo_Credential
		);
	}
	
	
	
	public function testClassNameCanBeUsedToDetermineCredentialFactory()
	{
		$this->_config->set(
			'group2', 'conn2.dbms', 'Mephex_Db_Sql_Pdo_CredentialFactory_Mysql'
		);
		$this->_config->set('group2', 'conn2.database', 'does_not_matter');
		$this->_config->set('group2', 'conn2.host', 'does_not_matter');
		
		$credential	= $this->_credential_factory->loadFromConfig(
			$this->_config, 'group2', 'conn2'
		);
		
		$this->assertTrue(
			$credential instanceof Mephex_Db_Sql_Pdo_Credential
		);
	}
}  