<?php



class Mephex_Db_Sql_Base_QueryTest
extends Mephex_Test_TestCase
{
	protected $_connection	= null;
	
	
	
	public function setUp()
	{	
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection();
	}
	
	
	
	protected function getQuery($sql = '', $prepared = Mephex_Db_Sql_Base_Query::PREPARE_NATIVE)
	{
		return new Stub_Mephex_Db_Sql_Base_Query($this->_connection, $sql, $prepared);
	}
	
	
	
	public function testConnectionIsSameObjectPassedToConstructor()
	{
		$this->assertTrue($this->_connection === $this->getQuery()->getConnection());
	}
	
	
	
	public function testQueryWithPreparedsOffUsingConnectionWithPreparedsOffDerivesToPreparedsOff()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_OFF, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithEmulatedPreparedsUsingConnectionWithPreparedsOffDerivesToPreparedsOff()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_OFF, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithNativePreparedsUsingConnectionWithPreparedsOffDerivesToPreparedsOff()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_OFF, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithPreparedsOffUsingConnectionWithEmulatedPreparedsDerivesToPreparedsOff()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_OFF, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithEmulatedPreparedsUsingConnectionWithEmulatedPreparedsDerivesToEmulatedPrepareds()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithNativePreparedsUsingConnectionWithEmulatedPreparedsDerivesToEmulatedPrepareds()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithPreparedsOffUsingConnectionWithNativePreparedsDerivesToPreparedsOff()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_OFF, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithEmulatedPreparedsUsingConnectionWithNativePreparedsDerivesToEmulatedPrepareds()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testQueryWithNativePreparedsUsingConnectionWithNativePreparedsDerivesToNativePrepareds()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->_connection->setPreparedSetting(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->assertEquals(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE, 
			$query->getDerivedPreparedSetting()
		);
	}
	
	
	
	public function testSqlUsedIsSqlPassedToQueryConstructor()
	{
		$sql	= 'SELECT someField FROM someTable';
		$this->assertEquals($sql, $this->getQuery($sql)->getSql());
	}
	
	
	
	public function testFetchModeIsNamedColumnsByDefault()
	{
		$this->assertEquals(Mephex_Db_Sql_Base_Query::FETCH_NAMED,
			$this->getQuery()->getFetchMode()
		);
	}
	
	
	
	public function testFetchModeCanBeSetToNamed()
	{
		$query		= $this->getQuery();
		$fetch_mode	= Mephex_Db_Sql_Base_Query::FETCH_NAMED;
		
		$query->setFetchMode($fetch_mode);
		$this->assertEquals($fetch_mode, $query->getFetchMode());
	}
	
	
	
	public function testFetchModeCanBeSetToNumeric()
	{
		$query		= $this->getQuery();
		$fetch_mode	= Mephex_Db_Sql_Base_Query::FETCH_NUMERIC;
		
		$query->setFetchMode($fetch_mode);
		$this->assertEquals($fetch_mode, $query->getFetchMode());
	}
	
	
	
	public function testFetchModeCanBeSetToBoth()
	{
		$query		= $this->getQuery();
		$fetch_mode	= Mephex_Db_Sql_Base_Query::FETCH_NAMED
			| Mephex_Db_Sql_Base_Query::FETCH_NUMERIC;
		
		$query->setFetchMode($fetch_mode);
		$this->assertEquals($fetch_mode, $query->getFetchMode());
	}
	
	
	
	public function testQueryWithPreparedsOffExecutesWithoutPreparing()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_OFF);
		$this->assertTrue(Mephex_Db_Sql_Base_Query::PREPARE_OFF === $query->execute());	
	}
	
	
	
	public function testQueryWithEmulatedPreparedsExecutesWithoutPreparing()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->assertTrue(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED === $query->execute());
	}
	
	
	
	public function testQueryWithNativePreparedsExecutesWithoutPreparing()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->assertTrue(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE === $query->execute());
	}
}  