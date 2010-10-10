<?php



class Stub_Mephex_Db_Sql_Pdo_Connection
extends Mephex_Db_Sql_Pdo_Connection
{
	public function getReadCredential()
	{
		return $this->_read_credential;
	}
	
	
	
	public function getWriteCredential()
	{
		return $this->_write_credential;
	}
}