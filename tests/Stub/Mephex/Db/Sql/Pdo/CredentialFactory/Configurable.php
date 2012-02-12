<?php



class Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
extends Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
{
	public function getDetailsFactory($dbms)
		{return parent::getDetailsFactory($dbms);}
	public function getCredentialFactoryClassNames($dbms)
		{return parent::getCredentialFactoryClassNames($dbms);}
	public function getCredentialFactoryClassName($dbms)
		{return parent::getCredentialFactoryClassName($dbms);}
}