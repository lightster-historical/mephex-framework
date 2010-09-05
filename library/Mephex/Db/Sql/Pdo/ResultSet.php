<?php



/**
 * A result set iterator for PDO-powered queries. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_ResultSet
extends Mephex_Db_Sql_Base_ResultSet
{
	/**
	 * An array map of Mephex-to-PDO fetch mode constants.
	 *  
	 * @var array
	 */
	protected static $_mapped_fetch_mode	= null;
	
	
	/**
	 * The PDOStatement that was executed.
	 * 
	 * @var PDOStatement
	 */
	protected $_statement;
	
	
	/**
	 * The number of the current result.
	 * 
	 * @var int
	 */
	protected $_count	= null;
	
	/**
	 * The current record
	 * 
	 * @var array
	 * @var unknown_type
	 */
	protected $_current	= null;
	
	
	/**
	 * The fetch mode to use when returning a result (PDO constant)
	 * 
	 * @var int
	 */
	protected $_fetch_mode;
	
	
	
	/**
	 * @param PDOStatement $statement - the statement that contains the results
	 * @param int $fetch_mode - the fetch mode (Mephex constant) used when
	 * 		returning results
	 */
	public function __construct(PDO $conn, PDOStatement $statement, $fetch_mode)
	{
		$this->_last_insert_id	= $conn->lastInsertId();
		$this->_statement		= $statement;
		
		$this->_fetch_mode	= (
			isset(self::$_mapped_fetch_mode[$fetch_mode])
			?	self::$_mapped_fetch_mode[$fetch_mode]
			:	self::$_mapped_fetch_mode[0]);
	}
	
	
	
	/**
	 * Getter for the current result.
	 * 
	 * @return array
	 */
	public function current()
	{
		return $this->_current;
	}
	
	
	
	/**
	 * Getter for the record number of the current result.
	 * 
	 * @return int
	 */
	public function key()
	{
		return $this->_count;
	}
	
	
	
	/**
	 * Advances the iterator one step.
	 * 
	 * @return void
	 */
	public function next()
	{
		try
		{
			$this->_current	= $this->_statement->fetch($this->_fetch_mode);
			$this->_count++;
		}
		catch(PDOException $ex)
		{
			throw new Mephex_Db_Exception("Database query result could not be retrieved (SQLSTATE {$ex->getCode()}): {$ex->getMessage()}");
		}
	}
	
	
	
	/**
	 * Rewinds/initalizes the iterator to the beginning.
	 */
	public function rewind()
	{
		if($this->_count === null)
		{
			try
			{
				$this->_count	= 0;
				$this->_current	= $this->_statement->fetch($this->_fetch_mode);
			}
			catch(PDOException $ex)
			{
				throw new Mephex_Db_Exception("Database query result could not be retrieved (SQLSTATE {$ex->getCode()}): {$ex->getMessage()}");
			}
		}
		else
		{
			throw new Mephex_Db_Exception("Cannot re-use database ResultSet.");
		}	
	}
	
	
	
	/**
	 * Determines if the iterator (still) has a result.
	 */
	public function valid()
	{
		return $this->_current !== null && $this->_current !== false;
	}
	
	
	
	/**
	 * Retrieves the autoincrement id of the first row from the most recent insert.
	 * 
	 * @return int
	 */
	public function getLastInsertId()
	{
		return $this->_last_insert_id;
	}
	
	
	
	/**
	 * Initializes the class' static variables.
	 */
	public function initStaticVariables()
	{
		if(null === self::$_mapped_fetch_mode)
		{
			self::$_mapped_fetch_mode	= array
			(
				0												=> PDO::FETCH_ASSOC,
				Mephex_Db_Sql_Base_Query::FETCH_NAMED 
					| Mephex_Db_Sql_Base_Query::FETCH_NUMERIC	=> PDO::FETCH_BOTH,
				Mephex_Db_Sql_Base_Query::FETCH_NAMED			=> PDO::FETCH_ASSOC,
				Mephex_Db_Sql_Base_Query::FETCH_NUMERIC			=> PDO::FETCH_NUM
			);
		}
	}
}



Mephex_Db_Sql_Pdo_ResultSet::initStaticVariables();
