<?php



/**
 * An abstract database query that supports communication with a
 * database server via SQL statements.
 * 
 * @author mlight
 */
abstract class Mephex_Db_Sql_Base_Query
{
	/**
	 * 'Off' prepared statements setting. Causes prepared statements
	 * to not be used.
	 * 
	 * @var int
	 */
	const PREPARE_OFF		= 0;
	/**
	 * 'Emulated' prepared statements setting. Causes emulated prepared statements
	 * to be used.
	 * 
	 * @var int
	 */
	const PREPARE_EMULATED	= 1;
	/**
	 * 'Native' prepared statements setting. Causes native prepared statements
	 * to be used.
	 * 
	 * @var int
	 */
	const PREPARE_NATIVE	= 2;
	
	
	/**
	 * 'Named' result fetch setting. Causes results to be fetched using column
	 * names as indexes.
	 * 
	 * @var int
	 */
	const FETCH_NAMED		= 1;
	/**
	 * 'Numeric' result fetch setting. Causes results to be fetched using column
	 * numbers as indexes.
	 * 
	 * @var int
	 */
	const FETCH_NUMERIC		= 2;
	
	
	
	/**
	 * The connection that should be used when executing this query.
	 * 
	 * @var Mephex_Db_Sql_Base_Connection
	 */
	protected $_connection;
	
	/**
	 * The prepared statement setting to use when executing this query.
	 * 
	 * @var int
	 */
	protected $_prepared;
	
	/**
	 * The fetch mode setting to use when returning the result set.
	 * 
	 * @var int
	 */
	protected $_fetch_mode;
	
	/**
	 * The SQL statement to execute.
	 * 
	 * @var string
	 */
	protected $_sql;
	
	

	/**
	 * @param Mephex_Db_Sql_Base_Connection $connection - the connection to use
	 * 		when executing the query 
	 * @param string $sql - the query to execute
	 * @param int $prepared - the prepared statement setting
	 */
	public function __construct(Mephex_Db_Sql_Base_Connection $connection, $sql, $prepared)
	{
		$this->_connection	= $connection;
		$this->_prepared	= $prepared;
		
		$this->_sql			= $sql;
		
		$this->_fetch_mode	= self::FETCH_NAMED;
	}
	
	
	
	/**
	 * Getter for connection.
	 * 
	 * @return Mephex_Db_Sql_Base_Connection
	 */
	protected function getConnection()
	{
		return $this->_connection;
	}
	
	

	/**
	 * Returns the prepared statement setting derived from the query object's
	 * setting and the connection's setting.
	 * 
	 * @return int
	 */
	public function getDerivedPreparedSetting()
	{
		return min($this->_connection->getPreparedSetting(), $this->_prepared);
	}
	
	
	
	/**
	 * Getter for the SQL query.
	 * 
	 * @return string
	 */
	public function getSql()
	{
		return $this->_sql;
	}
	
	
	
	/**
	 * Setter for fetch mode.
	 * 
	 * @param int $fetch_mode - the fetch mode to use when returning
	 * 		the result set
	 * @return void
	 */
	public function setFetchMode($fetch_mode)
	{
		$this->_fetch_mode	= ((self::FETCH_NAMED | self::FETCH_NUMERIC) & $fetch_mode);
	}
	
	
	
	/**
	 * Getter for fetch mode.
	 * 
	 * @return int
	 */
	public function getFetchMode()
	{
		return $this->_fetch_mode;
	}
	
	
	
	/**
	 * Executes the query using the given parameters.
	 * 
	 * @param array $params - parameters to place in the query placeholders.
	 */
	public function execute(array $params = array())
	{
		switch($this->getDerivedPreparedSetting())
		{			
			case self::PREPARE_NATIVE:
				return $this->executeNativePrepare($params);
			break;
			
			case self::PREPARE_EMULATED:
				return $this->executeEmulatedPrepare($params);
			break;
		}
		
		return $this->executeNonPrepare($params);
	}
	
	
	
	/**
	 * Executes the query as a native prepared statement.
	 * 
	 * @param array $params
	 */
	protected abstract function executeNativePrepare(array $params);
	/**
	 * Executes the query as an emulated prepared statement.
	 * 
	 * @param array $params
	 */
	protected abstract function executeEmulatedPrepare(array $params);
	/**
	 * Executes the query as a non-prepared statement.
	 * 
	 * @param array $params
	 */
	protected abstract function executeNonPrepare(array $params);
}