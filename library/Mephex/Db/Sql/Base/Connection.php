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

	/**
	 * The credential to use for making the connection.
	 *
	 * @var Mephex_Db_Sql_Base_Credential
	 */
	protected $_credential	= null;
	
	/**
	 * The quoter responsible for quoting table names, column names, and
	 * values.
	 * 
	 * @var Mephex_Db_Sql_Quoter
	 */
	private $_quoter		= null;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Base_Credential $credential - the credential
	 *		to be used for making the connection
	 */
	public function __construct(Mephex_Db_Sql_Base_Credential $credential)
	{
		$this->_credential	= $credential;
		$this->_quoter		= $credential->getQuoter();
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



	/**
	 * Getter for credential.
	 *
	 * @return Mephex_Db_Sql_Base_Credential
	 */
	public function getCredential()
	{
		return $this->_credential;
	}
	
	
	
	/**
	 * Getter for quoter.
	 * 
	 * @return Mephex_Db_Sql_Quoter
	 */
	public function getQuoter()
	{
		return $this->_quoter;
	}
	
	
	
	/**
	 * Generates an INSERT query.
	 * 
	 * @param string $table
	 * @param array $columns
	 * @return Mephex_Db_Sql_Base_Generator_Insert
	 */
	public function generateInsert($table, array $columns)
	{
		return new Mephex_Db_Sql_Base_Generator_Insert(
			$this->getQuoter(),
			$table,
			$columns
		);
	}
	
	
	
	/**
	 * Generates an UPDATE query.
	 * 
	 * @param string $table
	 * @param array $update_columns
	 * @param array $update_columns
	 * @return Mephex_Db_Sql_Base_Generator_Insert
	 */
	public function generateUpdate($table, array $update_columns, array $where_columns)
	{
		return new Mephex_Db_Sql_Base_Generator_Update(
			$this->getQuoter(), 
			$table,
			$update_columns, 
			$where_columns
		);
	}
}