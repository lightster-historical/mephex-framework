<?php



class Stub_Mephex_Db_Sql_Pdo_ConnectionFactory
extends Mephex_Db_Sql_Pdo_ConnectionFactory
{
	protected function connectUsingCredentials(
		Mephex_Db_Sql_Quoter $quoter,
		Mephex_Db_Sql_Pdo_Credential $write_credential,
		Mephex_Db_Sql_Pdo_Credential $read_credential = null
	)
	{
		return new Stub_Mephex_Db_Sql_Pdo_Connection(
			$quoter,
			$write_credential,
			$read_credential
		);
	}
}