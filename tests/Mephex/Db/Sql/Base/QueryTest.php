<?php



class Mephex_Db_Sql_Base_QueryTest
extends Mephex_Test_TestCase
{
	protected $_connection	= null;
	
	
	
	public function setUp()
	{	
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection(
			new Stub_Mephex_Db_Sql_Base_Credential(
				new Mephex_Db_Sql_Base_Quoter_Mysql()
			)
		);
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
	
	
	
	public function testQueryWithEmulatedPreparedsExecutesWithEmulatedPrepareds()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
		$this->assertTrue(Mephex_Db_Sql_Base_Query::PREPARE_EMULATED === $query->execute());
	}
	
	
	
	public function testQueryWithNativePreparedsExecutesWithNativePrepareds()
	{
		$query	= $this->getQuery('', Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
		$this->assertTrue(Mephex_Db_Sql_Base_Query::PREPARE_NATIVE === $query->execute());
	}



	public function testReadQueryUsesReadPdoConnection()
	{
		$db_w	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$db_r	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		
		$conn	= $this->getSqliteConnection($db_w, $db_w);
		$pdo_r	= $conn->getReadConnection();
		$pdo_w	= $conn->getWriteConnection();
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 'SELECT ...', Mephex_Db_Sql_Pdo_Query::PREPARE_OFF
		);
		
		$this->assertTrue($pdo_r === $query->getPdoConnection());
		$this->assertFalse($pdo_w === $query->getPdoConnection());
	}
	
	

	public function testNativePreparedsCanBeUsedToRead()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_NATIVE
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(4));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(2, $count);
	}
	
	

	public function testNativePreparedsCanBeReusedToRead()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_NATIVE
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(4));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(2, $count);
		
		$count	= 0;
		$result	= $query->execute($params = array(2));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(4, $count);
		
		$count	= 0;
		$result	= $query->execute($params = array(5));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(1, $count);
	}
	
	

	public function testEmulatedPreparedsCanBeUsedToRead()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_EMULATED
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(4));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(2, $count);
	}
	
	

	public function testEmulatedPreparedsCanBeReusedToRead()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_EMULATED
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(4));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(2, $count);
		
		$count	= 0;
		$result	= $query->execute($params = array(2));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(4, $count);
		
		$count	= 0;
		$result	= $query->execute($params = array(5));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(1, $count);
	}
	
	

	public function testNonPreparedsCanBeUsedToRead()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= 4', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_OFF
		);
		
		$count	= 0;
		$result	= $query->execute();
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(2, $count);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testFailedReadQueryThrowsException()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		$conn->read('SELECT * FROM does_not_exist')->execute();
	}



	public function testWriteQueryUsesWritePdoConnection()
	{
		$db_w	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$db_r	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		
		$conn	= $this->getSqliteConnection($db_w, $db_w);
		$pdo_r	= $conn->getReadConnection();
		$pdo_w	= $conn->getWriteConnection();
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Write(
			$conn, 'INSERT ...', Mephex_Db_Sql_Pdo_Query::PREPARE_OFF
		);
		
		$this->assertFalse($pdo_r === $query->getPdoConnection());
		$this->assertTrue($pdo_w === $query->getPdoConnection());
	}
	
	

	public function testNativePreparedsCanBeUsedToWrite()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Write(
			$conn, 
			'INSERT INTO number VALUES (?)', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_NATIVE
		);
		$query->execute($params = array(6));
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_NATIVE
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(6));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(1, $count);
	}
	
	

	public function testNativePreparedsCanBeReusedToWrite()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Write(
			$conn, 
			'INSERT INTO number VALUES (?)', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_NATIVE
		);
		$query->execute($params = array(6));
		$query->execute($params = array(7));
		$query->execute($params = array(8));
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_NATIVE
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(6));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(3, $count);
	}
	
	

	public function testEmulatedPreparedsCanBeUsedToWrite()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Write(
			$conn, 
			'INSERT INTO number VALUES (?)', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_EMULATED
		);
		$query->execute($params = array(6));
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_EMULATED
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(6));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(1, $count);
	}
	
	

	public function testEmulatedPreparedsCanBeReusedToWrite()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Write(
			$conn, 
			'INSERT INTO number VALUES (?)', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_EMULATED
		);
		$query->execute($params = array(6));
		$query->execute($params = array(7));
		$query->execute($params = array(8));
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= ?', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_EMULATED
		);
		
		$count	= 0;
		$result	= $query->execute($params = array(6));
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertEquals(3, $count);
	}
	
	

	public function testNonPreparedsCanBeUsedToWrite()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Write(
			$conn, 
			'INSERT INTO number VALUES (6)', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_OFF
		);
		$query->execute();
		
		$query	= new Stub_Mephex_Db_Sql_Pdo_Query_Read(
			$conn, 
			'SELECT * FROM number WHERE number >= 6', 
			Mephex_Db_Sql_Pdo_Query::PREPARE_OFF
		);
		$count	= 0;
		$result	= $query->execute();
		foreach($result as $dev)
		{
			$count++;
		}
		$this->assertTrue($conn->getReadConnection() === $conn->getWriteConnection());
		$this->assertEquals(1, $count);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testFailedWriteQueryThrowsException()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		$conn->write('INSERT INTO does_not_exist VALUES (1)')->execute();
	}
}  