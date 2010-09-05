<?php



/**
 * A database query that supports communication with a
 * database server via a PDO-powered connection.
 * 
 * @author mlight
 */
abstract class Mephex_Db_Sql_Pdo_Query
extends Mephex_Db_Sql_Base_Query
{
	/**
	 * The PDOStatement that allows execution of the query.
	 * 
	 * @var PDOStatement
	 */
	protected $_statement;
	
	protected $_last_insert_id;
	

	
	/**
	 * @param Mephex_Db_Sql_Pdo_Connection $connection - the connection to use
	 * 		when executing the query
	 * @param string $sql - the SQL query to execute
	 * @param int $prepared - the type of prepared statement to use
	 */
	public function __construct(Mephex_Db_Sql_Pdo_Connection $connection, $sql, $prepared)
	{
		parent::__construct($connection, $sql, $prepared);
	}
	
	
	
	/**
	 * Retrieves the PDO connection to use for this particular query.
	 * 
	 * @return PDO
	 */
	protected abstract function getPdoConnection();
	
	
	
	/**
	 * Executes the query using the given parameters.
	 * 
	 * @param array $params - parameters to place in the query placeholders.
	 * @return Mephex_Db_Sql_Pdo_ResultSet
	 */
	public function execute(array & $params = array())
	{
		try
		{
			return parent::execute($params);
		}
		catch(PDOException $ex)
		{
			throw new Mephex_Db_Exception("Database query error (SQLSTATE {$ex->getCode()}): {$ex->getMessage()}");
		}
	}
	
	
	
	/**
	 * Executes a query using native prepared statements.
	 * 
	 * @param array $params - the parameters to put into the prepared statement
	 * @return Mephex_Db_Sql_Pdo_ResultSet
	 */
	protected function executeNativePrepare(array & $params)
	{
		return $this->executePrepared($params, false);
	}
	
	
	
	/**
	 * Executes a query using emulated prepared statements.
	 * 
	 * @param array $params - the parameters to put into the prepared statement
	 * @return Mephex_Db_Sql_Pdo_ResultSet
	 */
	protected function executeEmulatedPrepare(array & $params)
	{
		return $this->executePrepared($params, true);
	}
	
	
	
	/**
	 * Executes a query using either native or emulated prepared statements.
	 * 
	 * @param array $params - the parameters to put into the prepared statement
	 * @param bool $emulated - TRUE if the prepared statements should be emulated
	 * @return Mephex_Db_Sql_Pdo_ResultSet
	 */
	protected function executePrepared(array & $params, $emulated)
	{
		$conn	= $this->getPdoConnection(); 
			
		if(null === $this->_statement)
		{
			$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, $emulated);
			$this->_statement	= $conn->prepare($this->getSql());
		}
		else
		{
			$this->_statement->closeCursor();
		}

		$this->_statement->execute($params);
		
		return new Mephex_Db_Sql_Pdo_ResultSet($conn, $this->_statement, $this->getFetchMode());
	}
	
	
	
	/**
	 * Executes a query without using prepared statements.
	 * 
	 * @param array $params - the parameters to put into the prepared statement
	 * @return Mephex_Db_Sql_Pdo_ResultSet
	 */
	protected function executeNonPrepare(array & $params)
	{
		$conn	= $this->getPdoConnection();
		$this->_statement	= $conn->query($this->getSql());
		return new Mephex_Db_Sql_Pdo_ResultSet($conn, $this->_statement, $this->getFetchMode());
	}
}