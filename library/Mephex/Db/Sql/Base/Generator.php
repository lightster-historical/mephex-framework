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
	 * Retrieves the values ordered in the provided order list. 
	 * 
	 * @param array $order
	 * @param array $params
	 * @param bool $quoted - whether or not to quote the values
	 * @return array
	 */
	protected function getOrderedValues(array $order, array & $params, $quoted)
	{
		$values	= array();
		foreach($order as $key)
		{
			if(!array_key_exists($key, $params))
			{
				throw new Mephex_Db_Exception("Expected parameter '{$key}' was not provided.");
			}

			if($quoted)
			{
				$values[]	= $this->_quoter->quoteValue($params[$key]); 
			}
			else
			{
				$values[]	= $params[$key];
			}
		}
		
		return $values;
	}
}