<?php



class Mephex_Db_Sql_Pdo_ConnectionFactoryTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	protected $_connection_factory;
	protected $_config;
	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_config	= new Mephex_Config_OptionSet();
		$this->_credential_factory	= new Mephex_Db_Sql_Pdo_CredentialFactory_Configurable(
			$this->_config,
			'group123'
		);
		$this->_connection_factory	= new Stub_Mephex_Db_Sql_Pdo_ConnectionFactory(
			$this->_credential_factory
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnExceptionIsThrownIfNoMatchingCredentialsAreFound()
	{
		$this->_connection_factory->getConnection('conn1');
	}
	
	
	
	public function testAConnectionCanBeGeneratedUsingSeparateReadAndWriteCredentials()
	{
		$this->_config->set(
			'group123',
			'conn2.dbms',
			'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy'
		);
		$this->_config->set(
			'group123',
			'conn2.write.dsn',
			'custom://dsn/db_write'
		);
		$this->_config->set(
			'group123',
			'conn2.read.dsn',
			'custom://dsn/db_read'
		);
		
		$connection	= $this->_connection_factory->getConnection('conn2');
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
		
		$this->assertEquals(
			'group123',
			$connection->getWriteCredential()->getUsername()
		);
		$this->assertEquals(
			'conn2.write',
			$connection->getWriteCredential()->getPassword()
		);
		
		$this->assertEquals(
			'group123',
			$connection->getReadCredential()->getUsername()
		);
		$this->assertEquals(
			'conn2.read',
			$connection->getReadCredential()->getPassword()
		);
	}
	
	
	
	public function testAConnectionCanBeGeneratedUsingOnlyAWriteCredential()
	{
		$this->_config->set(
			'group123',
			'conn3.dbms',
			'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy'
		);
		$this->_config->set(
			'group123',
			'conn3.write.dsn',
			'custom://dsn/db'
		);
		
		$connection	= $this->_connection_factory->getConnection('conn3');
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
		
		$this->assertEquals(
			'group123',
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
		$this->_config->set(
			'group123',
			'conn4.dbms',
			'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy'
		);
		$this->_config->set(
			'group123',
			'conn4.dsn',
			'custom://dsn/db'
		);
		
		$connection	= $this->_connection_factory->getConnection('conn4');
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
		
		$this->assertEquals(
			'group123',
			$connection->getWriteCredential()->getUsername()
		);
		$this->assertEquals(
			'conn4',
			$connection->getWriteCredential()->getPassword()
		);
		
		$this->assertNull($connection->getReadCredential());
	}
	
	
	
	public function testAConnectionCanBeGeneratedUsingAConnectionName()
	{
		$this->_connection_factory	= new Mephex_Db_Sql_Pdo_ConnectionFactory(
			$this->_credential_factory
		);
		
		$this->_config->set(
			'group123',
			'conn0.dbms',
			'Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy'
		);
		$this->_config->set(
			'group123',
			'conn0.dsn',
			'custom://dsn/db'
		);
		
		$connection	= $this->_connection_factory->getConnection('conn0');
		
		$this->assertTrue($connection instanceof Mephex_Db_Sql_Pdo_Connection);
	}
}  