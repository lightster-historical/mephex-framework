<?php



/**
 * Generates a credential for a Sqlite connection using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialFactory_Sqlite
extends Mephex_Db_Sql_Pdo_CredentialFactory_Dbms
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	
	/**
	 * Generates a credential for a Sqlite connection using a config option set,
	 * the group name, and connection name.
	 * 
	 * @param Mephex_Config_OptionSet $config
	 * @param string $group
	 * @param string $connection_name
	 * @return Mephex_Db_Sql_Pdo_Credential
	 */
	public function loadFromConfig(
		Mephex_Config_OptionSet $config, $group, $connection_name
	)
	{
		$database	= $config->get($group, "{$connection_name}.database");
		
		return new Mephex_Db_Sql_Pdo_Credential("sqlite:{$database}");
	}
}