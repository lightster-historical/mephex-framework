<?php



/**
 * Writer stream that retrieves its raw record from a database query.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Stream_Writer_Database
extends Mephex_Model_Stream_Writer
{
	/**
	 * The database connection used by the stream writer.
	 * 
	 * @var Mephex_Db_Sql_Base_Connection
	 */
	protected $_connection;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Base_Connection $connection
	 */
	public function __construct(Mephex_Db_Sql_Base_Connection $connection)
	{
		$this->_connection	= $connection;
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
}  