<?php



class Stub_Mephex_Db_Sql_Base_Insert
extends Mephex_Db_Sql_Base_Insert
{
	public function getQuoter()
	{
		return $this->_quoter;
	}
}