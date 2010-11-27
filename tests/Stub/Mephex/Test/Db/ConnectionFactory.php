<?php



class Stub_Mephex_Test_Db_ConnectionFactory
extends Mephex_Test_Db_ConnectionFactory
{
	public function getTmpCopier()
	{
		return $this->_tmp_copier;
	}
	
	
	
	public function getDriverClassNames($driver)
		{return parent::getDriverClassNames($driver);}
}