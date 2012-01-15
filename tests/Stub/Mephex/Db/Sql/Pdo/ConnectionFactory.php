<?php



class Stub_Mephex_Db_Sql_Pdo_ConnectionFactory
extends Mephex_Db_Sql_Pdo_ConnectionFactory
{
	protected function connectUsingCredential(
		Mephex_Db_Sql_Pdo_Credential $credential
	)
	{
		return new Stub_Mephex_Db_Sql_Pdo_Connection($credential);
	}
}