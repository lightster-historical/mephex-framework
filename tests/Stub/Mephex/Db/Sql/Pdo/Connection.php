<?php



/**
 * A PDO-powered database connection.
 * 
 * @author mlight
 */
class Stub_Mephex_Db_Sql_Pdo_Connection
extends Mephex_Db_Sql_Pdo_Connection
{
	public function getConnectionUsingCredential(Mephex_Db_Sql_Pdo_CredentialDetails $credential)
		{return parent::getConnectionUsingCredential($credential);}
}