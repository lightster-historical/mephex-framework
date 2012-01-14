<?php



/**
 * A PDO-powered database connection.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Connection
extends Mephex_Db_Sql_Base_Connection
{
	/**
	 * The credential used for connecting to the master/writable server.
	 * 
	 * @var Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	protected $_write_credential;
	
	/**
	 * The credential used for connecting to the slave/readable server.
	 * 
	 * @var Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	protected $_read_credential;
	
	/**
	 * The PDO connection used for write (master) queries.
	 * 
	 * @var PDO
	 */
	protected $_write_connection	= null;
	
	/**
	 * The PDO connection used for read (slave) queries.
	 * 
	 * @var PDO
	 */
	protected $_read_connection		= null;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Quoter $quoter - the quoter used for escaping SQL
	 *		query values, fields, and table names
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $write_credential - the credential used
	 * 		for connecting to the master/writable server
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $read_credential - the credential used
	 * 		for connection to the slave/readable server; if not provided, the
	 * 		write connection is used as the read connection
	 */
	public function __construct(
		Mephex_Db_Sql_Quoter $quoter,
		Mephex_Db_Sql_Pdo_CredentialDetails $write_credential,
		Mephex_Db_Sql_Pdo_CredentialDetails $read_credential = null)
	{
		parent::__construct($quoter);
		
		$this->_write_credential	= $write_credential;
		$this->_read_credential		= $read_credential;
	}
	
	
	
	/**
	 * Generates a PDO connection using the given credential
	 * 
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $credential
	 * @return PDO
	 */
	protected function getConnectionUsingCredential(Mephex_Db_Sql_Pdo_CredentialDetails $credential)
	{
		try
		{
			$pdo	= new PDO(
				$credential->getDataSourceName(),
				$credential->getUsername(),
				$credential->getPassword(),
				$credential->getDriverOptions()
			);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $pdo;
		}
		catch(PDOException $ex)
		{
			throw new Mephex_Db_Exception("Database connection error (SQLSTATE {$ex->getCode()}): {$ex->getMessage()}");
		}
	}
	
	
	
	/**
	 * Lazy-loading getter for the read (slave) connection.
	 * 
	 * @return PDO
	 */
	public function getReadConnection()
	{
		if(null === $this->_read_connection)
		{
			if(null !== $this->_read_credential)
			{
				$this->_read_connection	= $this->getConnectionUsingCredential(
					$this->_read_credential
				);
			}
			else
			{
				$this->_read_connection	= $this->getWriteConnection();
			}
		}
		
		return $this->_read_connection;
	}
	
	
	
	/**
	 * Lazy-loading getter for the write (master) connection.
	 * 
	 * @return PDO
	 */
	public function getWriteConnection()
	{
		if(null === $this->_write_connection)
		{
			$this->_write_connection	= $this->getConnectionUsingCredential(
				$this->_write_credential
			);
		}
		
		return $this->_write_connection;
	}
	
	
	
	/**
	 * Destroys the connections.
	 * 
	 * @return void
	 */
	public function __destruct()
	{
		parent::__destruct();
		
		// closes the PDO connection
		$this->_write_connection = null;
		$this->_read_connection	 = null;
	}
	
	
	
	/**
	 * Executes a query using the read (slave) connection. 
	 * 
	 * @param string $sql - the SQL to execute
	 * @param int $prepared - the prepared setting
	 * @return Mephex_Db_Sql_Base_Query
	 */
	public function read($sql, $prepared = Mephex_Db_Sql_Base_Query::PREPARE_OFF)
	{
		return new Mephex_Db_Sql_Pdo_Query_Read($this, $sql, $prepared);
	}
	
	
	
	/**
	 * Executes a query using the write (master) connection. 
	 * 
	 * @param string $sql - the SQL to execute
	 * @param int $prepared - the prepared setting
	 * @return Mephex_Db_Sql_Base_Query
	 */
	public function write($sql, $prepared = Mephex_Db_Sql_Base_Query::PREPARE_OFF)
	{
		return new Mephex_Db_Sql_Pdo_Query_Write($this, $sql, $prepared);
	}
}