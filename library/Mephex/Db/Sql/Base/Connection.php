<?php



/**
 * An abstract database connection that supports reading and writing
 * from a database using SQL statements. 
 * 
 * @author mlight
 */
abstract class Mephex_Db_Sql_Base_Connection
{
	/**
	 * The most liberally allowed prepared setting. For example,
	 * if the query is set to use native prepareds and the connection
	 * has prepareds set to off or emulated, non-prepareds or emulated
	 * prepareds are used, respectively.
	 * 
	 * @var int (Mephex_Db_Sql_Base_Query::PREPARE_*)
	 */
	protected $_prepared	= Mephex_Db_Sql_Base_Query::PREPARE_NATIVE;
	
	
	
	public function __construct()
	{
	}
	
	
	
	public function __destruct()
	{
	}
	
	
	
	/**
	 * Executes a query using the read (slave) connection. 
	 * 
	 * @param string $sql - the SQL to execute
	 * @param int $prepared - the prepared setting
	 * @return Mephex_Db_Sql_Base_Query
	 */
	public abstract function read($sql, $prepared = Mephex_Db_Sql_Base_Query::PREPARE_OFF);
	
	
	
	/**
	 * Executes a query using the write (master) connection. 
	 * 
	 * @param string $sql - the SQL to execute
	 * @param int $prepared - the prepared setting
	 * @return Mephex_Db_Sql_Base_Query
	 */
	public abstract function write($sql, $prepared = Mephex_Db_Sql_Base_Query::PREPARE_OFF);
	
	
	
	/**
	 * Getter for the prepared setting.
	 * 
	 * @return int
	 */
	public function getPreparedSetting()
	{
		return $this->_prepared;
	}
	
	
	
	/**
	 * Setter for the prepared setting.
	 * 
	 * @param int $prepared
	 * @return void
	 */
	public function setPreparedSetting($prepared)
	{
		$this->_prepared	= (int)$prepared;
	}
}