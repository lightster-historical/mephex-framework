<?php



class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_MysqlTest
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

		$this->_details_factory	= new Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql(
			$this->_config,
			$this->_group
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql
	 */
	public function testFactoryIsAConfigurableCredentialDetailsFactory()
	{
		$this->assertInstanceOf(
			'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable',
			$this->_details_factory
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 * @expectedException Mephex_Config_OptionSet_Exception_UnknownKey
	 */
	public function testAnExceptionIsThrownIfDatabaseOptionIsNotFound()
	{
		$this->_details_factory->getCredentialDetails('conn2');
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 * @expectedException Mephex_Config_OptionSet_Exception_UnknownKey
	 */
	public function testAnExceptionIsThrownIfNeitherHostNorSocketOptionsAreFound()
	{
		$this->_config->set($this->_group, 'conn3.database', 'dbname');
		
		$this->_details_factory->getCredentialDetails('conn3');
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 */
	public function testDatabaseAndHostCanBeUsedToCreateACredential()
	{
		$this->_config->set($this->_group, 'conn4.database', 'dbname4');
		$this->_config->set($this->_group, 'conn4.host', 'hostname4');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals(
			'mysql:host=hostname4;dbname=dbname4',
			$credential->getDataSourceName()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 */
	public function testUsernameIsIncludedInCredentialIfProvided()
	{
		$this->_config->set($this->_group, 'conn4.database', 'dbname4');
		$this->_config->set($this->_group, 'conn4.host', 'hostname4');
		$this->_config->set($this->_group, 'conn4.username', 'username4');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals('username4', $credential->getUsername());
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 */
	public function testPasswordIsIncludedInCredentialIfProvided()
	{
		$this->_config->set($this->_group, 'conn4.database', 'dbname4');
		$this->_config->set($this->_group, 'conn4.host', 'hostname4');
		$this->_config->set($this->_group, 'conn4.password', 'password4');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals('password4', $credential->getPassword());
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 */
	public function testPortIsIncludedInCredentialIfHostAndPartAreProvided()
	{
		$this->_config->set($this->_group, 'conn4.database', 'dbname4');
		$this->_config->set($this->_group, 'conn4.host', 'hostname4');
		$this->_config->set($this->_group, 'conn4.port', '3306');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals(
			'mysql:host=hostname4;port=3306;dbname=dbname4',
			$credential->getDataSourceName()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 */
	public function testDatabaseAndSocketCanBeUsedToCreateACrdential()
	{
		$this->_config->set($this->_group, 'conn4.database', 'dbname4');
		$this->_config->set($this->_group, 'conn4.socket', 'socket.sock');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals(
			'mysql:unix_socket=socket.sock;dbname=dbname4',
			$credential->getDataSourceName()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getCredentialDetails
	 */
	public function testPortIsIgnoredIfSocketIsUsed()
	{
		$this->_config->set($this->_group, 'conn4.database', 'dbname4');
		$this->_config->set($this->_group, 'conn4.socket', 'socket.sock');
		$this->_config->set($this->_group, 'conn4.port', '3306');
		
		$credential	= $this->_details_factory->getCredentialDetails('conn4');
			
		$this->assertInstanceOf('Mephex_Db_Sql_Pdo_CredentialDetails', $credential);
		$this->assertEquals(
			'mysql:unix_socket=socket.sock;dbname=dbname4',
			$credential->getDataSourceName()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Mysql::getQuoter
	 */
	public function testQuoterIsAMysqlQuoter()
	{
		$this->assertInstanceOf(
			'Mephex_Db_Sql_Base_Quoter_Mysql',
			$this->_details_factory->getQuoter('conn5')
		);
	}
}  