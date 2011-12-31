<?php



/**
 * Generates a PDO connection for testing
 * based on options provided in a config option set. 
 * 
 * @author mlight
 */
class Mephex_Test_Db_Sql_Pdo_ConnectionFactory
extends Mephex_Db_Sql_Pdo_ConnectionFactory
{
	/**
	 * Generates a credential factory for use creating unit testing DB
	 * connections using the given config option set and the given config group.
	 *
	 * @param Mephex_Config_OptionSet $config - the config option set to use
	 *		for determining credential property values
	 * @param string $group - the config group to use for determining credential
	 * 		property values
	 * @return Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
	 * @see Mephex_Db_Sql_Pdo_ConnectionFactory#getCredentialFactory
	 */
	protected function getCredentialFactory(Mephex_Config_OptionSet $config, $group)
	{
		return new Mephex_Test_Db_Sql_Pdo_CredentialFactory_Configurable(
			$config,
			$group
		);
	}
}