<?php



/**
 * INSERT query generator.
 * 
 * @author lightster
 */
class Mephex_Db_Sql_Base_Insert
{
	/**
	 * The table the record is being inserted into.
	 * 
	 * @var string
	 */
	protected $_table;
	
	/**
	 * The list of columns that values are being set for.
	 * 
	 * @var unknown_type
	 */
	protected $_columns;
	
	
	/**
	 * The insert query up to, but not including, the VALUES
	 * portion of the query.
	 * 
	 * @var string
	 */
	protected $_cached_sql		= null;
	
	/**
	 * A string containing one question mark per column, delimited
	 * by commas. This is used for prepared statement queries.
	 * 
	 * @var string
	 */
	protected $_cached_qmarks	= null;	
	
	
	
	/**
	 * @param string $table - the name of the table being insered into
	 * @param array $columns - the list of columns that values will be
	 * 		inserted for 
	 * @param Mephex_Db_Sql_Base_Quoter $quoter - the object responsible for
	 * 		quoting table names, column names, and values
	 */
	public function __construct($table, array $columns, Mephex_Db_Sql_Base_Quoter $quoter = null)
	{
		// if a quoter is not provided, use the default
		$this->_quoter	= (null === $quoter
			? new Mephex_Db_Sql_Base_Quoter()
			: $quoter
		);
		
		$this->_table	= $table;
		$this->_columns	= $columns;
		
		$quoted_columns	= array();
		foreach($columns as $column)
		{
			$quoted_columns[]	= $this->_quoter->quoteColumn($column);
		}
		
		$this->_cached_sql		= "INSERT INTO " 
			. $this->_quoter->quoteTable($this->_table) 
			. " (" . implode(',', $quoted_columns) . ")
		";
		$this->_cached_qmarks	= implode(',', array_fill(0, count($this->_columns), '?'));
	}
	
	
	
	/**
	 * Retrieves the SQL for the INSERT query.
	 * 
	 * @param array $params - the parameters to place in the VALUE clause
	 * @return string
	 */
	public function getSql(array $params = null)
	{
		if(null === $params)
		{
			return $this->_cached_sql . ' VALUES (' . $this->_cached_qmarks . ')';
		}
		else
		{
			$values	= $this->getOrderedValues($params, true);
			
			return $this->_cached_sql . ' VALUES (' . implode(',', $values) . ')';
		}
	}
	
	
	
	/**
	 * Retrieves the values ordered in the same way that the columns
	 * were ordered in the column list. 
	 * 
	 * @param array $params
	 * @param bool $quoted - whether or not to quote the values
	 * @return array
	 */
	public function getOrderedValues(array & $params, $quoted = false)
	{
		$values	= array();
		foreach($this->_columns as $column)
		{
			if(!array_key_exists($column, $params))
			{
				throw new Mephex_Db_Exception("Expected parameter '{$column}' was not be provided.");
			}

			if($quoted)
			{
				$values[]	= $this->_quoter->quoteValue($params[$column]); 
			}
			else
			{
				$values[]	= $params[$column];
			}
		}
		
		return $values;
	}
}