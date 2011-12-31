<?php



class Stub_Mephex_Test_Db_Sql_Pdo_ConnectionFactory
extends Mephex_Test_Db_Sql_Pdo_ConnectionFactory
{
	public function getCredentialFactory(Mephex_Config_OptionSet $config, $group)
		{return parent::getCredentialFactory($config, $group);}
}