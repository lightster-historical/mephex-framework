<?php



/**
 * A database credential that provides enough information to make
 * a PDO connection. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Credential
{
	/**
	 * The data source name (DSN) used to connect to the database server.
	 * 
	 * @var string
	 */
	protected $_data_source_name;
	
	/**
	 * The username used to authenticate with the database server.
	 * 
	 * @var string
	 */
	protected $_username;
	
	/**
	 * The password used to authenticate with the database server.
	 * 
	 * @var string
	 */
	protected $_password;
	
	/**
	 * Any options to be used when connecting to the database server.
	 * 
	 * @var array
	 */
	protected $_driver_options;
	
	
	
	/**
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array $driver_options
	 */
	public function __construct($dsn, $username = null, $password = null, array & $driver_options = array())
	{
		$this->_data_source_name	= $dsn;
		$this->_username			= $username;
		$this->_password			= $password;
		$this->_driver_options		= $driver_options;
	}
	
	
	
	/**
	 * Getter for DSN
	 * 
	 * @return string
	 */
	public function getDataSourceName()
	{
		return $this->_data_source_name;
	}
	
	
	
	/**
	 * Getter for username
	 * 
	 * @return string
	 */
	public function getUsername()
	{
		return $this->_username;	
	}
	
	
	
	/**
	 * Getter for password
	 * 
	 * @return string
	 */
	public function getPassword()
	{
		return $this->_password;
	}
	
	
	
	/**
	 * Getter for driver options
	 * 
	 * @return array
	 */
	public function getDriverOptions()
	{
		return $this->_driver_options;
	}
}