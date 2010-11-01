<?php



class Stub_Mephex_Db_Sql_Base_Generator
extends Mephex_Db_Sql_Base_Generator
{
	public function getOrderedValues(array $order, array $params, $quoted)
		{return parent::getOrderedValues($order, $params, $quoted);}
	
	
	
	public function getQuoter()
	{
		return $this->_quoter;
	}
}