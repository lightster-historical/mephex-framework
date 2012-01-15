<?php



class Mephex_Db_ConnectionManager_ConfigurableTest
extends Mephex_Test_TestCase
{
	protected $_config;
	protected $_connections;
	protected $_connection_factory;
	protected $_manager;
	
	
	
	protected function setUp()
	{
		parent::setUp();

		$this->_config			= new Mephex_Config_OptionSet();
		$this->_config->set('custom', 'b.nickname', 'b-connected');
		$this->_config->set('custom', 'database.connections', array(
			'a',
			'b',
			'c'
		));
		$this->_config->set('custom', 'database.bad-list', null);

		$quoter		= new Mephex_Db_Sql_Base_Quoter_Mysql();
		$credential	= new Stub_Mephex_Db_Sql_Base_Credential($quoter);

		$this->_connections		= array(
			'a'	=> new Stub_Mephex_Db_Sql_Base_Connection($credential),
			'b'	=> new Stub_Mephex_Db_Sql_Base_Connection($credential),
			'c'	=> new Stub_Mephex_Db_Sql_Base_Connection($credential),
		);
		$this->_connection_factory	= new Stub_Mephex_Db_Sql_ConnectionFactory(
			$this->_connections
		);

		$this->_manager			= new Stub_Mephex_Db_ConnectionManager_Configurable(
			$this->_config
		);
		$this->_manager->setConnectionFactory(
			'custom', $this->_connection_factory
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::__construct
	 */
	public function testConfigurableConnectionManagerInheritsConnectionManager()
	{
		$this->assertTrue(
			$this->_manager
			instanceof
			Mephex_Db_ConnectionManager
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::getConnectionFactory
	 * @covers Mephex_Db_ConnectionManager_Configurable::generateDefaultConnectionFactory
	 */
	public function testDefaultConnectionFactoryIsLazyLoaded()
	{
		$factory	= $this->_manager->getConnectionFactory('a');
		$this->assertTrue(
			$factory
			instanceof
			Mephex_Db_Sql_ConnectionFactory
		);
		$this->assertTrue(
			$factory
			===
			$this->_manager->getConnectionFactory('a')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::setConnectionFactory
	 * @covers Mephex_Db_ConnectionManager_Configurable::getConnectionFactory
	 */
	public function testConnectionFactoryCanBeSet()
	{
		$connection_factory	= new Stub_Mephex_Db_Sql_ConnectionFactory(
			$this->_connections
		);
		$this->_manager->setConnectionFactory('test', $connection_factory);
		$this->assertTrue(
			$connection_factory
			===
			$this->_manager->getConnectionFactory('test')
		);
	}



	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::getConnectionNickname
	 */
	public function testConnectionNicknameIsFound()
	{
		$this->assertEquals(
			'b-connected',
			$this->_manager->getConnectionNickname(
				$this->_config,
				'custom',
				'b'
			)
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::generateConnection
	 * @expectedException Mephex_Db_ConnectionManager_Exception_UnregisteredConnection
	 */
	public function testUnregisteredConnectionCannotBeGenerated()
	{
		$this->assertTrue(
			$this->_connections['a']
			===
			$this->_manager->generateConnection('a')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::addConnection
	 * @covers Mephex_Db_ConnectionManager_Configurable::generateConnection
	 */
	public function testConnectionWithoutNicknameCanBeGenerated()
	{
		$this->_manager->addConnection('custom', 'a');
		$this->assertTrue(
			$this->_connections['a']
			===
			$this->_manager->generateConnection('custom.a')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::addConnection
	 * @covers Mephex_Db_ConnectionManager_Configurable::generateConnection
	 */
	public function testConnectionWithNicknameCanBeGenerated()
	{
		$this->_manager->addConnection('custom', 'b');
		$this->assertTrue(
			$this->_connections['b']
			===
			$this->_manager->generateConnection('b-connected')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::addConnectionList
	 * @expectedException Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList
	 */
	public function testInvalidConnectionListCausesException()
	{
		$this->_manager->addConnectionList('custom', 'database.bad-list');
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager_Configurable::addConnectionList
	 * @covers Mephex_Db_ConnectionManager_Configurable::generateConnection
	 */
	public function testConnectionListConnectionsCanBeGenerated()
	{
		$this->_manager->addConnectionList('custom', 'database.connections');
		$this->assertTrue(
			$this->_connections['a']
			===
			$this->_manager->generateConnection('custom.a')
		);
		$this->assertTrue(
			$this->_connections['b']
			===
			$this->_manager->generateConnection('b-connected')
		);
		$this->assertTrue(
			$this->_connections['c']
			===
			$this->_manager->generateConnection('custom.c')
		);
	}
}