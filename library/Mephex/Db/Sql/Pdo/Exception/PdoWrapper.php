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
	 * The original PDOException that caused this exception to be thrown.
	 * 
	 * @var PDOException
	 */
	protected $_pdo_exception;
	
	
	
	/**
	 * @param PDOException $exception - the original PDO exception
	 * @param string $message - the message to prepend to the PDO message
	 */
	public function __construct(
		PDOException $pdo_exception,
		$message = 'PDO error'
	)
	{
		parent::__construct(
			"{$message} (SQLSTATE "
			. $pdo_exception->getCode() . "): " . $pdo_exception->getMessage()
		);
		
		$this->_pdo_exception	= $pdo_exception;
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