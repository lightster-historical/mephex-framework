<?php



/**
 * Generates a credential for a custom connection using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialFactory_CustomDsn
extends Mephex_Db_Sql_Pdo_CredentialFactory_Dbms
{
	/**
	 * Generates a credential for a custom connection using a config option set,
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
		$dsn		= $config->get($group, "{$connection_name}.dsn");
		$username	= $config->get($group, "{$connection_name}.username", null, false);
		$password	= $config->get($group, "{$connection_name}.password", null, false);
		
		return new Mephex_Db_Sql_Pdo_Credential(
			$dsn, 
			$username,
			$password
		);
	}
}