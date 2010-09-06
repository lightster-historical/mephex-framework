<?php



/**
 * A utility class for properly quoting database table names,
 * column names, and values.
 * 
 * @author lightster
 */
class Mephex_Db_Sql_Base_Quoter
{
	/**
	 * Quotes a table name.
	 * 
	 * @param string $table - the table name to be quoted
	 * @return string
	 */
	public function quoteTable($table)
	{
		return "`" . str_replace('`', '``', $table) . "`";	
	}
	
	
	
	/**
	 * Quotes a column name.
	 * 
	 * @param string $column - the column name to be quoted
	 * @return string
	 */
	public function quoteColumn($column)
	{
		return "`" . str_replace('`', '``', $column) . "`";
	}
	
	
	
	/**
	 * Quotes a value.
	 * 
	 * @param string $value - the value to be quoted
	 * @return string
	 */
	public function quoteValue($value)
	{
		return "'" . addslashes($value) . "'";
	}
}