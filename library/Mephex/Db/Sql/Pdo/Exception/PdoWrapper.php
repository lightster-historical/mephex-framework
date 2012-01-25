<?php



/**
 * Exception thrown when a PDOException is thrown.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Exception_PdoWrapper
extends Mephex_Db_Exception
{
	/**
	 * The connection that threw the exception.
	 * 
	 * @var Mephex_Db_Sql_Pdo_Connection
	 */
	protected $_connection;

	/**
	 * The original PDOException that caused this exception to be thrown.
	 * 
	 * @var PDOException
	 */
	protected $_pdo_exception;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Pdo_Connection $connection - the connection that
	 *		thew the exception
	 * @param PDOException $exception - the original PDO exception
	 */
	public function __construct(
		Mephex_Db_Sql_Pdo_Connection $connection,
		PDOException $pdo_exception,
		$message = 'PDO error'
	)
	{
		parent::__construct(
			"{$message} (SQLSTATE "
			. $pdo_exception->getCode() . "): " . $pdo_exception->getMessage()
		);
		
		$this->_connection		= $connection;
		$this->_pdo_exception	= $pdo_exception;
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
	
	
	
	/**
	 * Getter for PDO Exception.
	 * 
	 * @return PDOException
	 */
	public function getPdoException()
	{
		return $this->_pdo_exception;
	}
}