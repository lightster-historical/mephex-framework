<?php



/**
 * Exception thrown when a PDOException is thrown during PDO object initialization.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection
extends Mephex_Db_Sql_Pdo_Exception_PdoWrapper
{
	/**
	 * The connection that threw the exception.
	 * 
	 * @var Mephex_Db_Sql_Pdo_Connection
	 */
	protected $_connection;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Pdo_Connection $connection - the connection that
	 *		thew the exception
	 * @param PDOException $exception - the original PDO exception
	 * @param string $message - the message to prepend to the PDO message
	 */
	public function __construct(
		Mephex_Db_Sql_Pdo_Connection $connection,
		PDOException $pdo_exception,
		$message = 'PDO connection error'
	)
	{
		parent::__construct(
			$pdo_exception,
			"{$message} (SQLSTATE "
			. $pdo_exception->getCode() . "): " . $pdo_exception->getMessage()
		);
		
		$this->_connection		= $connection;
	}
	
	
	
	/**
	 * Getter for connection.
	 * 
	 * @return Mephex_Db_Sql_Pdo_Connection
	 */
	public function getConnection()
	{
		return $this->_connection;
	}
}