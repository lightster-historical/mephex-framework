<?php



class Stub_Mephex_Db_Sql_Base_Credential
implements Mephex_Db_Sql_Base_Credential
{
	protected $_quoter;



	public function __construct(Mephex_Db_Sql_Quoter $quoter)
	{
		$this->_quoter	= $quoter;
	}



	public function getQuoter()
	{
		return $this->_quoter;
	}
}