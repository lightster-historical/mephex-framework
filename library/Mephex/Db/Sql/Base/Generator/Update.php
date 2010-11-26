<?php



/**
 * UPDATE query generator.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Base_Generator_Update
extends Mephex_Db_Sql_Base_Generator
{
	/**
	 * The table the record is being updated in.
	 * 
	 * @var string
	 */
	protected $_table;
	
	/**
	 * The list of update columns that values are being set for.
	 * 
	 * @var array
	 */
	protected $_update_columns;
	
	/**
	 * The list of where columns that are being used in the update.
	 */
	protected $_where_columns;
	
	
	
	/**
	 * @param string $table - the name of the table being insered into
	 * @param array $columns - the list of columns that values will be
	 * 		inserted for 
	 * @param Mephex_Db_Sql_Quoter $quoter - the object responsible for
	 * 		quoting table names, column names, and values
	 */
	public function __construct(Mephex_Db_Sql_Quoter $quoter, $table
		, array $update_columns, array $where_columns)
	{
		parent::__construct($quoter);
		
		$this->_table			= $table;
		$this->_update_columns	= $update_columns;
		$this->_where_columns	= $where_columns;
	}
	
	
	
	/**
	 * Retrieves the SQL for the UPDATE query.
	 * 
	 * @param array $params - the parameters to place in the VALUE clause
	 * @return string
	 */
	public function getSql(array $update_params = null, array $where_params = null)
	{
		$update_sets	= $this->getFieldValueStrings($this->_update_columns, $update_params);
		$where_sets		= $this->getFieldValueStrings($this->_where_columns, $where_params); 
		
		return 'UPDATE ' . $this->_quoter->quoteTable($this->_table) 
			. ' SET ' . implode(',', $update_sets)
			. ' WHERE ' . implode(' AND ', $where_sets);
	}
	
	
	
	/**
	 * Retrieves the values ordered in the provided update clause column order. 
	 * 
	 * @param array $params
	 * @param bool $quoted - whether or not to quote the values
	 * @return array
	 */
	public function getUpdateColumnOrderedValues(array $params, $quoted)
	{
		return $this->getOrderedValues($this->_update_columns, $params, $quoted);
	}
	
	
	
	/**
	 * Retrieves the values ordered in the provided where clause column order. 
	 * 
	 * @param array $params
	 * @param bool $quoted - whether or not to quote the values
	 * @return array
	 */
	public function getWhereColumnOrderedValues(array $params, $quoted)
	{
		return $this->getOrderedValues($this->_where_columns, $params, $quoted);
	}
}