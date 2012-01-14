<?php



class Stub_Mephex_Db_Sql_Pdo_CredentialFactory_Dummy
extends Mephex_Db_Sql_Pdo_CredentialFactory_Dbms
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	
	public function loadFromConfig(
		Mephex_Config_OptionSet $config, $group, $connection_name
	)
	{
		return new Mephex_Db_Sql_Pdo_CredentialDetails(
			'dummy',
			$group,
			$connection_name 
		);
	}
}