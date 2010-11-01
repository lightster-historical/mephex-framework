<?php



/**
 * A utility class for properly quoting database table names,
 * column names, and values.
 * 
 * @author lightster
 */
abstract class Mephex_Db_Sql_Quoter
{
	/**
	 * Quotes a table name.
	 * 
	 * @param string $table - the table name to be quoted
	 * @return string
	 */
	public abstract function quoteTable($table);
	
	
	
	/**
	 * Quotes a column name.
	 * 
	 * @param string $column - the column name to be quoted
	 * @return string
	 */
	public abstract function quoteColumn($column);
	
	
	
	/**
	 * Quotes a value.
	 * 
	 * @param string $value - the value to be quoted
	 * @return string
	 */
	public abstract function quoteValue($value);
}