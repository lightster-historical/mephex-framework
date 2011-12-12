<?php



class Mephex_Db_Sql_Pdo_ConnectionFactoryTest
extends Mephex_Test_TestCase
{
	protected $_connection_factory;
	protected $_config;
	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_connection_factory	= new Stub_Mephex_Db_Sql_Pdo_ConnectionFactory();
		$this->_config	= new Mephex_Config_OptionSet();
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnExceptionIsThrownIfNoMatchingCredentialsAreFound()
	{
		$this->_connection_factory->connectUsingConfig(
			$this->_config, 'group1', 'conn1'
		);
	}
	
	
	
	public function testAConnectionCanBeGeneratedUsingSeparateReadAndWriteCredentials()
	{
		$this->_config->set('group2', 'conn2.write.dbms', 'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy');
		$this->_config->set('group2', 'conn2.read.dbms', 'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group2', 'conn2'
		);
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
		
		$this->assertEquals(
			'group2',
			$connection->getWriteCredential()->getUsername()
		);
		$this->assertEquals(
			'conn2.write',
			$connection->getWriteCredential()->getPassword()
		);
		
		$this->assertEquals(
			'group2',
			$connection->getReadCredential()->getUsername()
		);
		$this->assertEquals(
			'conn2.read',
			$connection->getReadCredential()->getPassword()
		);
	}
	
	
	
	public function testAConnectionCanBeGeneratedUsingOnlyAWriteCredential()
	{
		$this->_config->set('group3', 'conn3.write.dbms', 'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group3', 'conn3'
		);
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
		
		$this->assertEquals(
			'group3',
			$connection->getWriteCredential()->getUsername()
		);
		$this->assertEquals(
			'conn3.write',
			$connection->getWriteCredential()->getPassword()
		);
		
		$this->assertNull($connection->getReadCredential());
	}
	
	
	
	public function testAConnectionCanBeGeneratedUsingAGeneralCredential()
	{
		$this->_config->set('group4', 'conn4.dbms', 'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group4', 'conn4'
		);
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
		
		$this->assertEquals(
			'group4',
			$connection->getWriteCredential()->getUsername()
		);
		$this->assertEquals(
			'conn4',
			$connection->getWriteCredential()->getPassword()
		);
		
		$this->assertNull($connection->getReadCredential());
	}
	
	
	
	public function testAConnectionCanBeCreatedFromAConfigOptionSet()
	{
		$this->_connection_factory	= new Mephex_Db_Sql_Pdo_ConnectionFactory();
		
		$this->_config->set('group0', 'conn0.dbms', 'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy');
		
		$connection	= $this->_connection_factory->connectUsingConfig(
			$this->_config, 'group0', 'conn0'
		);
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
	}
}  