<?php



class Mephex_Db_Sql_Pdo_Query_WriteTest
extends Mephex_Test_TestCase
{
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