<?php



class Mephex_Db_Exporter_PhpUnit_XmlDataSetTest
extends Mephex_Test_TestCase
{
	protected $_importer;
	protected $_exporter;
	
	protected $_src_conn;
	protected $_dest_conn;
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_src_conn	= $this->getDbConnection('src');
		$this->_dest_conn	= $this->getDbConnection('dest');
		
		$this->loadXmlDataSetIntoDb($this->_src_conn, 'Mephex_Db_Exporter_PhpUnit', 'basic');
		
		$this->_exporter	= new Mephex_Db_Exporter_PhpUnit_XmlDataSet($this->_src_conn);
		$this->_importer	= new Mephex_Db_Importer_PhpUnit_XmlDataSet($this->_dest_conn);
	}
	
	
	
	protected function getConfigLoaders()
	{
		return array(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . '/Mephex/Db/Exporter/PhpUnit/config.ini'
			)
		);
	}
	
	
	
	public function testTablesCanBeExported()
	{
		$file_name	= PATH_TEST_ROOT . '/tmp/dbs_' . uniqid() . '.xml';
		
		$this->_exporter->addTable('test_1');
		$this->_exporter->addTable('test_2');
		
		$this->_exporter->export($file_name);
		$this->_importer->import($file_name);
		unlink($file_name);
		
		$counts	= array();
		$results	= $this->_dest_conn->read('
			SELECT 
				COUNT(id) AS count, 
				value 
			FROM test_1 
			GROUP BY value
		')->execute();
		foreach($results as $result)
		{
			$counts["{$result['value']}"]	= $result['count'];
		}
		$this->assertEquals(3, $counts['a']);
		$this->assertEquals(2, $counts['b']);
		$this->assertEquals(1, $counts['c']);
		$this->assertEquals(3, $counts['']);
		
		$counts	= array();
		$results	= $this->_dest_conn->read('
			SELECT 
				COUNT(id) AS count, 
				value 
			FROM test_2 
			GROUP BY value
		')->execute();
		foreach($results as $result)
		{
			$counts["{$result['value']}"]	= $result['count'];
		}
		$this->assertEquals(3, $counts['a']);
		$this->assertEquals(4, $counts['b']);
	}
	
	
	
	public function testNullValuesCanBeExported()
	{
		$file_name	= PATH_TEST_ROOT . '/tmp/dbs_' . uniqid() . '.xml';
		
		$this->_exporter->addTable('test_1');
		
		$this->_exporter->export($file_name);
		$this->_importer->import($file_name);
		unlink($file_name);
		
		$counts	= array();
		$results	= $this->_dest_conn->read('
			SELECT COUNT(id) AS count
			FROM test_1
			WHERE value IS NULL 
		')->execute();
		foreach($results as $result)
		{
			$counts[""]	= $result['count'];
		}
		$this->assertEquals(3, $counts['']);
	}
	
	
	
	public function testCustomQueriesCanBeExported()
	{
		$file_name	= PATH_TEST_ROOT . '/tmp/dbs_' . uniqid() . '.xml';
		
		$this->_exporter->addQuery(
			'test_1', 
			'SELECT * FROM test_1 GROUP BY value'
		);
		
		$this->_exporter->export($file_name);
		$this->_importer->import($file_name);
		unlink($file_name);
		
		$counts	= array();
		$results	= $this->_dest_conn->read('
			SELECT 
				COUNT(id) AS count, 
				value 
			FROM test_1 
			GROUP BY value
		')->execute();
		foreach($results as $result)
		{
			$counts["{$result['value']}"]	= $result['count'];
		}
		$this->assertEquals(1, $counts['a']);
		$this->assertEquals(1, $counts['b']);
		$this->assertEquals(1, $counts['c']);
		$this->assertEquals(1, $counts['']);
	}
}  