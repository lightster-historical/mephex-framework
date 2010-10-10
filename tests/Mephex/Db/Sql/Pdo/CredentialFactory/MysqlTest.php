<?php



class Mephex_Db_Sql_Pdo_CredentialFactory_MysqlTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	protected $_config;
	
	
	
	public function __construct()
	{	
		$this->_credential_factory	= new Mephex_Db_Sql_Pdo_CredentialFactory_Mysql();
		$this->_config	= new Mephex_Config_OptionSet();
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnExceptionIsThrownIfDatabaseOptionIsNotFound()
	{
		$this->_credential_factory->loadFromConfig($this->_config, 'group2', 'conn2');
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnExceptionIsThrownIfNeitherHostNorSocketOptionsAreFound()
	{
		$this->_config->set('group3', 'conn3.database', 'dbname');
		
		$this->_credential_factory->loadFromConfig($this->_config, 'group3', 'conn3');
	}
	
	
	
	public function testDatabaseAndHostCanBeUsedToCreateACredential()
	{
		$this->_config->set('group4', 'conn4.database', 'dbname4');
		$this->_config->set('group4', 'conn4.host', 'hostname4');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_Credential);
		$this->assertEquals('mysql:host=hostname4;dbname=dbname4', $credential->getDataSourceName());
	}
	
	
	
	public function testUsernameIsIncludedInCredentialIfProvided()
	{
		$this->_config->set('group4', 'conn4.database', 'dbname4');
		$this->_config->set('group4', 'conn4.host', 'hostname4');
		$this->_config->set('group4', 'conn4.username', 'username4');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_Credential);
		$this->assertEquals('username4', $credential->getUsername());
	}
	
	
	
	public function testPasswordIsIncludedInCredentialIfProvided()
	{
		$this->_config->set('group4', 'conn4.database', 'dbname4');
		$this->_config->set('group4', 'conn4.host', 'hostname4');
		$this->_config->set('group4', 'conn4.password', 'password4');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_Credential);
		$this->assertEquals('password4', $credential->getPassword());
	}
	
	
	
	public function testPortIsIncludedInCredentialIfHostAndPartAreProvided()
	{
		$this->_config->set('group4', 'conn4.database', 'dbname4');
		$this->_config->set('group4', 'conn4.host', 'hostname4');
		$this->_config->set('group4', 'conn4.port', '3306');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_Credential);
		$this->assertEquals('mysql:host=hostname4;port=3306;dbname=dbname4', $credential->getDataSourceName());
	}
	
	
	
	public function testDatabaseAndSocketCanBeUsedToCreateACrdential()
	{
		$this->_config->set('group4', 'conn4.database', 'dbname4');
		$this->_config->set('group4', 'conn4.socket', 'socket.sock');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_Credential);
		$this->assertEquals('mysql:unix_socket=socket.sock;dbname=dbname4', $credential->getDataSourceName());
	}
	
	
	
	public function testPortIsIgnoredIfSocketIsUsed()
	{
		$this->_config->set('group4', 'conn4.database', 'dbname4');
		$this->_config->set('group4', 'conn4.socket', 'socket.sock');
		$this->_config->set('group4', 'conn4.port', '3306');
		
		$credential	= 
			$this->_credential_factory->loadFromConfig($this->_config, 'group4', 'conn4');
			
		$this->assertTrue($credential instanceof Mephex_Db_Sql_Pdo_Credential);
		$this->assertEquals('mysql:unix_socket=socket.sock;dbname=dbname4', $credential->getDataSourceName());
	}
}  