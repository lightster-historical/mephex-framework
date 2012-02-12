<?php



class Stub_Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom
extends Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom
{
	// make protected methods public
	public function getQuoterClassNames($name)
		{return parent::getQuoterClassNames($name);}
	public function getQuoterClassName($name)
		{return parent::getQuoterClassName($name);}
}