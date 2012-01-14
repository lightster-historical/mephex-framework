<?php



/**
 * Generates a SQL-database connection based on 
 * options provided in a config option set. 
 * 
 * @author mlight
 */
interface Mephex_Db_Sql_Base_ConnectionFactory
{
	/**
	 * Generates a connection to a database using a config option set,
	 * the group name, and connection name.
	 * 
	 * @param Mephex_Config_OptionSet $config
	 * @param string $group
	 * @param string $connection_name
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	public function connectUsingConfig(
		Mephex_Config_OptionSet $config, $group, $connection_name
	);
}