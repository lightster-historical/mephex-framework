<?php



class Mephex_Db_ConnectionManagerTest
extends Mephex_Test_TestCase
{
	protected $_connections;
	protected $_manager;
	
	
	
	protected function setUp()
	{
		parent::setUp();

		$this->_connections		= array(
			'a'	=> new Stub_Mephex_Db_Sql_Base_Connection(),
			'b'	=> new Stub_Mephex_Db_Sql_Base_Connection(),
			'c'	=> new Stub_Mephex_Db_Sql_Base_Connection(),
		);
		$this->_manager			= new Stub_Mephex_Db_ConnectionManager(
			$this->_connections
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager::getConnection
	 */
	public function testConnectionCanBeRetrieved()
	{
		$this->assertTrue(
			$this->_connections['a']
			===
			$this->_manager->getConnection('a')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_ConnectionManager::getConnection
	 */
	public function testConnectionIsLazyLoaded()
	{
		$conn	= $this->_manager->getConnection('b');
		for($i = 0; $i < 5; $i++)
		{
			$this->assertTrue(
				$conn
				===
				$this->_manager->getConnection('b')
			);
		}

		$this->assertEquals(1, $this->_manager->getGeneratedCount('b'));
	}
}