<?php



class Stub_Mephex_Db_Sql_Base_Generator
extends Mephex_Db_Sql_Base_Generator
{
	public function getValue($key, array $params, $quoted)
		{return parent::getValue($key, $params, $quoted);}
	public function getOrderedValues(array $order, array $params, $quoted)
		{return parent::getOrderedValues($order, $params, $quoted);}
	public function getFieldValueStrings(array $order, array $params = null)
		{return parent::getFieldValueStrings($order, $params);}
	
	
	
	public function getQuoter()
	{
		return $this->_quoter;
	}
}