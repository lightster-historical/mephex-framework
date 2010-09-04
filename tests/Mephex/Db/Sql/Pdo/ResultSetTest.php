<?php



class Mephex_Db_Sql_Pdo_ResultSetTest
extends Mephex_Test_TestCase
{	
	public function testResultSetCanBeIterated()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		$pdo	= $conn->getReadConnection();
		
		$known		= range(1, 5);
		
		$this->assertTrue(count($known) > 0);
		
		$mismatch	= 0;
		$numbers	= $pdo->query('SELECT * FROM number');
		$iterator	= new Mephex_Db_Sql_Pdo_ResultSet($numbers, Mephex_Db_Sql_Base_Query::FETCH_NAMED);
		foreach($iterator as $key => $number)
		{
			if(isset($known[$key]) && $known[$key] == $number['number'])
			{
				unset($known[$key]);
			}
			else
			{
				$mismatch++;
			}
		}
		
		$mismatch	+= count($known);
		
		$this->assertEquals(0, $mismatch);
	}
	
	
	
	public function testNumericResultModeUsesColumnNumbersForKeys()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		$pdo	= $conn->getReadConnection();
		
		$mismatch	= 0;
		$numbers	= $pdo->query('SELECT * FROM number LIMIT 1');
		$iterator	= new Mephex_Db_Sql_Pdo_ResultSet($numbers, Mephex_Db_Sql_Base_Query::FETCH_NUMERIC);
		foreach($iterator as $key => $number)
		{
			$this->assertFalse(isset($number['number']));
			$this->assertTrue(isset($number[0]));
		}
	}
	
	
	
	public function testNamedResultModeUsesColumnNamesForKeys()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		$pdo	= $conn->getReadConnection();
		
		$numbers	= $pdo->query('SELECT * FROM number LIMIT 1');
		$iterator	= new Mephex_Db_Sql_Pdo_ResultSet($numbers, Mephex_Db_Sql_Base_Query::FETCH_NAMED);
		foreach($iterator as $key => $number)
		{
			$this->assertTrue(isset($number['number']));
			$this->assertFalse(isset($number[0]));
		}
	}
	
	
	
	public function testBothNamedAndNumericKeysCanBeUsed()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		$pdo	= $conn->getReadConnection();
		
		$mismatch	= 0;
		$numbers	= $pdo->query('SELECT * FROM number LIMIT 1');
		$iterator	= new Mephex_Db_Sql_Pdo_ResultSet($numbers,
			Mephex_Db_Sql_Base_Query::FETCH_NAMED | Mephex_Db_Sql_Base_Query::FETCH_NUMERIC
		);
		foreach($iterator as $key => $number)
		{
			$this->assertTrue(isset($number['number']));
			$this->assertTrue(isset($number[0]));
		}
	}
	
	
	
	public function testInvalidResultModeUsesColumnNamesForKeys()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		$pdo	= $conn->getReadConnection();
		
		$numbers	= $pdo->query('SELECT * FROM number LIMIT 1');
		$iterator	= new Mephex_Db_Sql_Pdo_ResultSet($numbers, -1);
		foreach($iterator as $key => $number)
		{
			$this->assertTrue(isset($number['number']));
			$this->assertFalse(isset($number[0]));
		}
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testRewindingAUsedResultSetThrowsAnException()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		$pdo	= $conn->getReadConnection();
		
		$numbers	= $pdo->query('SELECT * FROM number LIMIT 1');
		$iterator	= new Mephex_Db_Sql_Pdo_ResultSet($numbers, Mephex_Db_Sql_Base_Query::FETCH_NAMED);
		foreach($iterator as $key => $number)
		{
		}
		$iterator->rewind();
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testFailingToFetchAResultFromAStatementThrowsAnException()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query		= $conn->write('INSERT INTO does_not_exist VALUES (1)');
		$results	= $query->execute();
		foreach($results as $result)
		{
		} 
	}
}  