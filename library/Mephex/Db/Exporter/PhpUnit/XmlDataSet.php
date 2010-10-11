<?php



/**
 * Dataset exporter that exports a PHPUnit-style XML dataset
 * from a database.
 * 
 * @author mlight
 */
class Mephex_Db_Exporter_PhpUnit_XmlDataSet
{
	/**
	 * Database connection.
	 * 
	 * @var Mephex_Db_Sql_Base_Connection
	 */
	protected $_connection	= null;
	
	
	/**
	 * An of data-export queries to run, indexed by export table name. 
	 * 
	 * @var array
	 */
	protected $_queries		= array();
	
	
	
	/**
	 * @param Mephex_Db_Sql_Base_Connection $connection - the database
	 * 		the data should be selected from.
	 */
	public function __construct(Mephex_Db_Sql_Base_Connection $connection)
	{
		$this->_connection	= $connection;
	}
	
	
	
	/**
	 * Exports the dataset to the XML file provided by the given file name.
	 *  
	 * @param string $file_name
	 * @return void
	 */
	public function export($file_name)
	{
		$file	= fopen($file_name, 'w');
		
		fwrite($file, '<?xml version="1.0" encoding="UTF-8" ?>' . "\n");
		fwrite($file, "<dataset>\n");
		
		foreach($this->_queries as $table => $query)
		{
			$this->exportTable($file, $table, $query);
		}
		
		fwrite($file, "</dataset>\n");
		
		fclose($file);
	}
	
	
	
	/**
	 * Exports data for an individual table/query.
	 * 
	 * @param $fh - the file handle to write to
	 * @param string $table - the name of the table being exported
	 * @param string $query - the query that retrieves the data we need
	 * @return void
	 */
	protected function exportTable($fh, $table, $query)
	{
		$columns_written	= false;
		
		fwrite($fh, "\t<table name=\"{$table}\">\n");
			
		$results	= $this->_connection->read($query)->execute();
		foreach($results as $result)
		{
			if(!$columns_written)
			{
				foreach($result as $col => $value)
				{
					fwrite($fh, "\t\t<column>{$col}</column>\n");
				}
				
				$columns_written	= true;
			}
			
			fwrite($fh, "\n\t\t<row>\n");
			foreach ($result as $value)
			{
				fwrite($fh, "\t\t\t" .
					(null === $value
						? "<null />"
						: "<value><![CDATA[{$value}]]></value>"
					) . "\n"
				);
			}
			fwrite($fh, "\t\t</row>\n");
		}
		
		fwrite($fh, "\t</table>\n");
	}
	
	
	
	/**
	 * Adds a query to the list of queries/tables to export.
	 * 
	 * @param string $table - the name of the table being exported
	 * @param string $query - the SQL used to retrieve the data
	 * @return void
	 */
	public function addQuery($table, $query)
	{
		$this->_queries[$table]	= $query;
	}
	
	
	
	/**
	 * Adds a table to the list of tables to export.
	 * 
	 * @param string $table
	 * @return void
	 */
	public function addTable($table)
	{
		$this->addQuery($table, "SELECT * FROM {$table}");
	}
}