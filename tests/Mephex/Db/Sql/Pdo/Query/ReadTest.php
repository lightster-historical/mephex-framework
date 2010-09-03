<?php



class Mephex_Db_Sql_Pdo_Query_ReadTest
extends Mephex_Test_TestCase
{
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
}  