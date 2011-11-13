<?php



/**
 * An exception thrown when the config option that was supposed to contain
 * a connection list is not an array.
 * 
 * @author mlight
 */
class Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList
extends Mephex_Db_Exception
{
	/**
	 * The connection manager that was trying to use the connection list.
	 * 
	 * @var Mephex_Db_ConnectionManager_Configurable
	 */
	protected $_connection_manager;
	
	/**
	 * The config option group that was supposed to hold the connection list
	 * option.
	 * 
	 * @var string
	 */
	protected $_group;
	
	/**
	 * The config option that was supposed to hold the connection list.
	 * 
	 * @var string
	 */
	protected $_option;
	
	/**
	 * The actual value the config option held.
	 * 
	 * @var mixed
	 */
	protected $_value;
	
	
	
	/**
	 * @param Mephex_Db_ConnectionManager_Configurable $connection_manager -
	 *		the connection manager that was trying to use the connection list
	 * @param string $group - the config option group that holds the connection
	 *		list option
	 * @param string $option - the config option that holds the connection list
	 * @param mixed $value - the actual value the config option held
	 */
	public function __construct(
		Mephex_Db_ConnectionManager_Configurable $connection_manager,
		$group,
		$option,
		$value
	)
	{
		parent::__construct("Connection list config value must be an array.");
		
		$this->_connection_manager	= $connection_manager;
		$this->_group				= $group;
		$this->_option				= $option;
		$this->_value				= $value;
	}
	
	
	
	/**
	 * Getter for connection manager.
	 * 
	 * @return Mephex_Db_ConnectionManager_Configurable
	 */
	public function getConnectionManager()
	{
		return $this->_connection_manager;
	}
	
	
	
	/**
	 * Getter for group.
	 * 
	 * @return string
	 */
	public function getGroup()
	{
		return $this->_group;
	}
	
	
	
	/**
	 * Getter for option.
	 * 
	 * @return string
	 */
	public function getOption()
	{
		return $this->_option;
	}
	
	
	
	/**
	 * Getter for value.
	 * 
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->_value;
	}
}