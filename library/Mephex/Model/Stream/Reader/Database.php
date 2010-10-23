<?php



/**
 * Reader stream that retrieves its raw record from a database query.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Stream_Reader_Database
extends Mephex_Model_Stream_Reader
{
	/**
	 * The database connection used by the stream reader.
	 * 
	 * @var Mephex_Db_Sql_Base_Connection
	 */
	protected $_connection;
	
	/**
	 * The database table set used by the stream reader.
	 * 
	 * @var Mephex_Db_TableSet
	 */
	protected $_table_set;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Base_Connection $connection
	 */
	public function __construct(
		Mephex_Db_Sql_Base_Connection $connection,
		Mephex_Db_TableSet $table_set = null)
	{
		$this->_connection	= $connection;
		$this->_table_set	= $table_set ? $table_set : new Mephex_Db_TableSet();
	}
	
	
	
	/**
	 * Getter for the database connection.
	 * 
	 * @return Mephex_Db_Sql_Base_Connection
	 */
	protected function getConnection()
	{
		return $this->_connection;
	}
	
	
	
	/**
	 * Getter for table set.
	 * 
	 * @return Mephex_Db_TableSet
	 */
	protected function getTableSet()
	{
		return $this->_table_set;
	}
	
	
	
	/**
	 * Getter for table.
	 *
	 * @param string $table - the name of the table to retrieve from the
	 * 		table set 
	 * @return string
	 */
	protected function getTable($table)
	{
		return $this->_table_set->get($table);
	}
}  