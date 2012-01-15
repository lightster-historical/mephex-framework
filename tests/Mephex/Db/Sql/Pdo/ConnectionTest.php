<?php



class Mephex_Db_Sql_Pdo_ConnectionTest
extends Mephex_Test_TestCase
{	
	public function testConnectionCanBeMade()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		$pdo	= $conn->getReadConnection();
		
		$known		= array(
			'lightster'				=> 'Matt Light'
		);
		
		$this->assertTrue(count($known) > 0);
		
		$mismatch	= 0;
		$developers	= $pdo->query('SELECT * FROM developer');
		while($developer = $developers->fetch())
		{
			if(!empty($known[$developer['nickname']])
				&& $known[$developer['nickname']] === $developer['name'])
			{
				unset($known[$developer['nickname']]);
			}
			else
			{
				$mismatch++;
			}
		}
		
		$mismatch	+= count($known);
		
		$this->assertEquals(0, $mismatch);
	}
	
	

	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testFailingToMakeAConnectionThrowsAnException()
	{
		$credential	= $this->getSqliteCredential(PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'readonly' . DIRECTORY_SEPARATOR . 'does_not_exist.sqlite3');
		$conn		= new Mephex_Db_Sql_Pdo_Connection(
			new Mephex_Db_Sql_Pdo_Credential(
				new Mephex_Db_Sql_Base_Quoter_Sqlite(),
				$credential,
				$credential
			)
		);
		$conn->getReadConnection();
		
		$this->assertTrue(true);
	}
	
	
	
	public function testWriteConnectionIsUsedIfReadCredentialIsNotProvided()
	{
		$db_rw	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_rw);
		
		$this->assertTrue(
			$conn->getReadConnection() === $conn->getWriteConnection()
		);
	}
	
	
	
	public function testReadAndWriteConnectionsCanBeDifferent()
	{
		$db_w	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$db_r	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db_w, $db_w);
		
		$this->assertTrue(
			$conn->getReadConnection() !== $conn->getWriteConnection()
		);
	}
	
	
	
	public function testWritingToTheWriteConnectionDoesNotNecessarilyWriteToTheReadConnection()
	{
		$db_w	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$db_r	= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		
		$conn	= $this->getSqliteConnection($db_w, $db_w);
		$pdo_w	= $conn->getWriteConnection();
		$pdo_r	= $conn->getReadConnection();
		
		$pdo_w->query("INSERT INTO developer (`nickname`) VALUES ('dummy')");
		
		$has_devs	= false;
		$developers	= $pdo_w->query("SELECT * FROM developer WHERE nickname = 'dummy'");
		while($developer = $developers->fetch())
		{
			$this->assertFalse($has_devs);
			$has_devs	= true;
		}
		$this->assertTrue($has_devs);
		
		$has_devs	= false;
		$developers	= $pdo_r->query("SELECT * FROM developer WHERE nickname = 'dummy'");
		while($developer = $developers->fetch())
		{
			$this->assertFalse(true);
		}
		$this->assertFalse($has_devs);
	}
	
	
	
	public function testWriteThroughConnectionReturnsWriteQuery()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= $conn->write('INSERT ...');
		$this->assertTrue($query instanceof Mephex_Db_Sql_Pdo_Query_Write);
	}
	
	
	
	public function testReadThroughConnectionReturnsReadQuery()
	{
		$db		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$conn	= $this->getSqliteConnection($db);
		
		$query	= $conn->read('SELECT ...');
		$this->assertTrue($query instanceof Mephex_Db_Sql_Pdo_Query_Read);
	}
	
	
	
//	public function testRunQuery()
//	{
//		$conn	= $this->getConnection();
//		$c		= 0;
//		for($j = 0; $j < 10; $j++)
//		{
//			$race_query	= $conn->read("SELECT * FROM nascarRace", Mephex_Db_Sql_Base_Query::PREPARE_NATIVE);
//			$query		= $conn->read("SELECT * FROM nascarResult WHERE raceId = ?", Mephex_Db_Sql_Base_Query::PREPARE_EMULATED);
//				
//			$races		= $race_query->execute();
//			foreach($races as $race)
//			{
//				$results	= $query->execute($params = array($race['raceId']));
////		var_dump($results);exit;
//				foreach($results as $i => $result)
//				{
//					var_dump($result);exit;
//					$c++;
//				}
////				var_dump($i);
//			}
//		}
//		
//		var_dump($c);
//	}
}  