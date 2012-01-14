<?php



/**
 * Generates a testing credential for a Sqlite connection using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite
extends Mephex_Db_Sql_Pdo_CredentialFactory_Sqlite
{
	/**
	 * Generates a credential for a Sqlite connection using a config option set,
	 * the group name, and connection name.
	 * 
	 * @param Mephex_Config_OptionSet $config
	 * @param string $group
	 * @param string $connection_name
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	public function loadFromConfig(
		Mephex_Config_OptionSet $config, $group, $connection_name
	)
	{
		if(!$config->hasOption($group, "{$connection_name}.original_database"))
		{
			$src_database	= $config->get($group, "{$connection_name}.database");
			$copier			= $config->get($group, "{$connection_name}.tmp_copier");
			
			$database_copy	= $copier->copy($src_database);
			
			$config->set($group, "{$connection_name}.database", $database_copy, true);
			$config->set($group, "{$connection_name}.original_database", $src_database, true);
		}

		return parent::loadFromConfig($config, $group, $connection_name);
	}
}