<?php



/**
 * Generates a credential for a given DBMS using a config option set. 
 * 
 * @author mlight
 */
abstract class Mephex_Db_Sql_Pdo_CredentialFactory_Dbms
{
	public function __construct()
	{
	}
	
	
	
	/**
	 * Generates a credential for a given DBMS using a config option set,
	 * the group name, and connection name.
	 * 
	 * @param Mephex_Config_OptionSet $config
	 * @param string $group
	 * @param string $connection_name
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	public abstract function loadFromConfig(
		Mephex_Config_OptionSet $config, $group, $connection_name
	);
}