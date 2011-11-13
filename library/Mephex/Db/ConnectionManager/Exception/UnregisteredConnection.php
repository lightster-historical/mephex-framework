<?php



/**
 * An exception thrown when the connection name that was being generated has
 * not been registered as a valid connection name.
 * 
 * @author mlight
 */
class Mephex_Db_ConnectionManager_Exception_UnregisteredConnection
extends Mephex_Db_Exception
{
	/**
	 * The connection manager that was trying to generate the connection.
	 * 
	 * @var Mephex_Db_ConnectionManager
	 */
	protected $_connection_manager;
	
	/**
	 * The name of the connection that the connection manager was attempting 
	 * to generate.
	 * 
	 * @var string
	 */
	protected $_name;
	
	
	
	/**
	 * @param Mephex_Db_ConnectionManager $connection_manager - the connection
	 *		manager that was trying to generate the connection.
	 * @param string $name - the name of the connection that the connection
	 *		manager was attempting to generate.
	 */
	public function __construct(
		Mephex_Db_ConnectionManager $connection_manager,
		$name
	)
	{
		parent::__construct("Unknown database connection: {$name}");
		
		$this->_connection_manager	= $connection_manager;
		$this->_name				= $name;
	}
	
	
	
	/**
	 * Getter for connection manager.
	 * 
	 * @return object
	 */
	public function getConnectionManager()
	{
		return $this->_connection_manager;
	}
	
	
	
	/**
	 * Getter for name.
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
}