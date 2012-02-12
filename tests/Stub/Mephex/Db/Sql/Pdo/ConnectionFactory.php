<?php



class Stub_Mephex_Db_Sql_Pdo_ConnectionFactory
extends Mephex_Db_Sql_Pdo_ConnectionFactory
{
	public function getConnection($name)
	{
		return new Stub_Mephex_Db_Sql_Pdo_Connection(
			$this->_credential_factory->getCredential($name)
		);
	}
}