<?php



/**
 * Generates a connection based on options provided in a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_ConnectionFactory
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
	 * @return Mephex_Db_Sql_Pdo_Credential
	 */
	public function connectUsingConfig(
		Mephex_Config_OptionSet $config, $group, $connection_name
	)
	{
		$driver	= $config->get($group, "{$connection_name}.driver");
		
		$classes	= array
		(
			"Mephex_Db_Sql_{$driver}_ConnectionFactory",
			$driver
		);
		
		foreach($classes as $class)
		{
			if(class_exists($class))
			{
				$factory	= new $class();
				if($factory instanceof Mephex_Db_Sql_Base_ConnectionFactory)
				{
					return $factory->connectUsingConfig($config, $group, $connection_name);
				}
			}
		}
		
		throw new Mephex_Exception("Unknown database driver: {$driver}");
	}
}