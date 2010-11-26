<?php



/**
 * SQL query generator.
 * 
 * @author mlight
 */
abstract class Mephex_Db_Sql_Base_Generator
{
	/**
	 * The quoter to use for quoting table names, column names, and values
	 * 
	 * @var Mephex_Db_Sql_Quoter
	 */
	protected $_quoter;
	
	
	
	/**
	 * @param Mephex_Db_Sql_Quoter $quoter - the quoter responsible for
	 * 		quoting table names, column names, and values
	 */
	public function __construct(Mephex_Db_Sql_Quoter $quoter)
	{
		$this->_quoter	= $quoter;
	}
	
	
	
	/**
	 * Uses the given key to retrieve a value from the params associative array
	 * 
	 * @param string $key - the column name we need a value for
	 * @param array $params - the associative array containing the values 
	 * @param bool $quoted - whether or not to quote the retrieved value
	 * @return string
	 * @throws Mephex_Db_Exception
	 */
	protected function getValue($key, array $params, $quoted)
	{
		if(!array_key_exists($key, $params))
		{
			throw new Mephex_Db_Exception("Expected parameter '{$key}' was not provided.");
		}

		if($quoted)
		{
			return $this->_quoter->quoteValue($params[$key]); 
		}
		else
		{
			return $params[$key];
		}
	}
	
	
	
	/**
	 * Retrieves the values ordered in the provided order list. 
	 * 
	 * @param array $order
	 * @param array $params
	 * @param bool $quoted - whether or not to quote the values
	 * @return array
	 */
	protected function getOrderedValues(array $order, array $params, $quoted)
	{
		$values	= array();
		foreach($order as $key)
		{
			$values[]	= $this->getValue($key, $params, $quoted);
		}
		
		return $values;
	}
	
	
	
	/**
	 * Generates an array of field-value strings. For example:
	 * 
	 * array
	 * (
	 * 		0 => '`field1` = 'a value',
	 * 		1 => '`field2` = 'another value'
	 * )
	 * 
	 * @param array $order - the column names, ordered as needed
	 * @param array $params - an associative array of values, using column
	 * 		names as keys
	 * @return array
	 */
	protected function getFieldValueStrings(array $order, array $params = null)
	{
		$values	= array();
		foreach($order as $key)
		{
			$value			= (
				null === $params
				? '?'
				: $this->getValue($key, $params, true)
			);
			$values[]	= $this->_quoter->quoteColumn($key)
				. '=' . $value;
		}
		
		return $values;
	}
}