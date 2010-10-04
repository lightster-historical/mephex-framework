<?php



class Mephex_Db_Importer_PhpUnit_XmlDataSetTest
extends Mephex_Test_TestCase
{
	protected $_data_set;
	
	protected $_conn;
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$db				= $this->getSqliteDatabase('Mephex_Db_Importer_PhpUnit', 'basic');
		$this->_conn	= $this->getSqliteConnection($db);
		
		$this->_data_set	= new Mephex_Db_Importer_PhpUnit_XmlDataSet($this->_conn);
	}
	
	
	
	protected function tearDown()
	{
		parent::tearDown();
		
		$this->_data_set	= null;
	}
	
	
	
	public function testTableIsTruncatedPriorToDataImport()
	{
		$this->_conn->write('DELETE FROM test')->execute();
		$this->_conn->write('INSERT INTO test (`id`, `key`) VALUES (\'1\', \'test\')')->execute();
			
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM test')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertTrue($row['count'] > 0);
		
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/empty.xml'
			) 
		);
		
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM test')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertEquals(0, $row['count']);
	}
	
	
	
	public function testOnlyRelevantTablesAreTruncatedPriorToDataImport()
	{
		$this->_conn->write('DELETE FROM test')->execute();
		$this->_conn->write('INSERT INTO test (`id`, `key`) VALUES (\'1\', \'test\')')->execute();
		$this->_conn->write('INSERT INTO names (`id`, `first_name`, `last_name`) VALUES (\'1\', \'John\', \'Smith\')')->execute();
			
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM test')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertTrue($row['count'] > 0);
		
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM names')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertTrue($row['count'] > 0);
		
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/empty.xml'
			) 
		);
		
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM test')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertEquals(0, $row['count']);
		
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM names')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertTrue($row['count'] > 0);
	}
	
	
	
	public function testAllRowsAreImported()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/basic.xml'
			) 
		);
		
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM test')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertEquals(3, $row['count']);
	}
	
	
	
	public function testAllRowsAreImportedForMultipleTables()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/multiple_tables.xml'
			) 
		);
		
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM test')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertEquals(2, $row['count']);
		
		$result	= $this->_conn->read('SELECT COUNT(*) AS count FROM names')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertEquals(3, $row['count']);
	}
	
	
	
	public function testEmptyStringAreCorrectlyImported()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/basic.xml'
			) 
		);
		
		$result	= $this->_conn->read('SELECT * FROM test WHERE old_key = \'\' LIMIT 1')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertTrue('' === $row['old_key']);
	}
	
	
	
	public function testNullsAreCorrectlyImported()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/basic.xml'
			) 
		);
		
		$result	= $this->_conn->read('SELECT * FROM test WHERE old_key IS NULL LIMIT 1')->execute();
		$result->rewind();
		$row	= $result->current();
		$this->assertNull($row['old_key']);
	}
	
	
	
	public function testAllDataIsImportedAsExpected()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/multiple_tables.xml'
			) 
		);
		
		$result	= $this->_conn->read('SELECT * FROM test')->execute();
			$result->rewind();
			$row	= $result->current();
			$this->assertEquals(1, $row['id']);
			$this->assertEquals('abc', $row['key']);
			
			$result->next();
			$row	= $result->current();
			$this->assertEquals(3, $row['id']);
			$this->assertEquals('ghi', $row['key']);
		
		$result	= $this->_conn->read('SELECT * FROM names')->execute();
			$result->rewind();
			$row	= $result->current();
			$this->assertEquals(1, $row['id']);
			$this->assertEquals('John', $row['first_name']);
			$this->assertEquals('Smith', $row['last_name']);
			
			$result->next();
			$row	= $result->current();
			$this->assertEquals(2, $row['id']);
			$this->assertEquals('Jane', $row['first_name']);
			$this->assertEquals('Smith', $row['last_name']);
			
			$result->next();
			$row	= $result->current();
			$this->assertEquals(3, $row['id']);
			$this->assertEquals('Baby', $row['first_name']);
			$this->assertEquals('Smith-Smith', $row['last_name']);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testUnexpectedCdataCausesAnExceptionToBeThrown()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/unexpected_cdata.xml'
			) 
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testUnexpectedTagCausesAnExceptionToBeThrown()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/unexpected_tag.xml'
			) 
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testEmptyTableNameCausesAnExceptionToBeThrown()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/empty_table_name.xml'
			) 
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testMissingTableNameCausesAnExceptionToBeThrown()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/missing_table_name.xml'
			) 
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testMissingValueCausesAnExceptionToBeThrown()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/missing_value.xml'
			) 
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testExtraValueCausesAnExceptionToBeThrown()
	{
		$this->_data_set->import(PATH_TEST_ROOT 
			. str_replace(
				'/', 
				DIRECTORY_SEPARATOR, 
				'/Mephex/Db/Importer/PhpUnit/dbs/extra_values.xml'
			) 
		);
	}
}  