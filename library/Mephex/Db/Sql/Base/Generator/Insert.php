<?php



/**
 * INSERT query generator.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Base_Generator_Insert
extends Mephex_Db_Sql_Base_Generator
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
	 * @param Mephex_Db_Sql_Quoter $quoter - the object responsible for
	 * 		quoting table names, column names, and values
	 * @param string $table - the name of the table being insered into
	 * @param array $columns - the list of columns that values will be
	 * 		inserted for 
	 */
	public function __construct(Mephex_Db_Sql_Quoter $quoter, $table, array $columns)
	{
		parent::__construct($quoter);
		
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
			$values	= $this->getColumnOrderedValues($params, true);
			
			return $this->_cached_sql . ' VALUES (' . implode(',', $values) . ')';
		}
	}
	
	
	
	/**
	 * Retrieves the values ordered in the provided column order. 
	 * 
	 * @param array $params
	 * @param bool $quoted - whether or not to quote the values
	 * @return array
	 */
	public function getColumnOrderedValues(array $params, $quoted)
	{
		return $this->getOrderedValues($this->_columns, $params, $quoted);
	}
}