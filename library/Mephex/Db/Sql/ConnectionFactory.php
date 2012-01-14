<?php



/**
 * Generates a connection based on options provided in a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_ConnectionFactory
{
	public function __construct()
	{
	}
	
	
	
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
	)
	{
		$driver	= $config->get($group, "{$connection_name}.driver");
		
		$classes			= $this->getDriverClassNames($driver);
		$credential_factory	= $this->getCredentialFactory(
			$config,
			$group
		);
		
		foreach($classes as $class)
		{
			if(class_exists($class))
			{
				$factory	= new $class($credential_factory);
				if($factory instanceof Mephex_Db_Sql_Base_ConnectionFactory)
				{
					return $factory->getConnection($connection_name);
				}
			}
		}
		
		throw new Mephex_Exception("Unknown database driver: {$driver}");
	}



	/**
	 * Returns a credential factory for the given config option set and group.
	 *
	 * @param Mephex_Config_OptionSet $config
	 * @param string $group
	 * @return Mephex_Db_Sql_Pdo_CredentialFactory
	 */
	protected function getCredentialFactory(Mephex_Config_OptionSet $config, $group)
	{
		return new Mephex_Db_Sql_Pdo_CredentialFactory_Configurable(
			$config,
			$group
		);
	}
	
	
	
	/**
	 * Generates a list of possible driver class names based on the driver name.
	 * 
	 * @param string $driver - the driver name (e.g. Pdo)
	 * @return array
	 */
	protected function getDriverClassNames($driver)
	{
		return array
		(
			"Mephex_Db_Sql_{$driver}_ConnectionFactory",
			$driver
		);
	}
}