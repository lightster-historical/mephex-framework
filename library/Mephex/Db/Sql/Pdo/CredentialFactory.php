<?php



/**
 * Generates a credential for a given DBMS using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialFactory
{
	/**
	 * Generates a credential for a given DBMS using a config option set,
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
		$dbms	= $config->get($group, "{$connection_name}.dbms");
		
		$classes	= $this->getDbmsClassNames($dbms);
		
		foreach($classes as $class)
		{
			if(class_exists($class))
			{
				$factory	= new $class();
				if($factory instanceof Mephex_Db_Sql_Pdo_CredentialFactory_Dbms)
				{
					return $factory->loadFromConfig($config, $group, $connection_name);
				}
			}
		}
		
		throw new Mephex_Exception("Unknown dbms: {$dbms}");
	}
	
	
	
	/**
	 * Generates a list of possible DBMS class names based on the DBMS name.
	 * 
	 * @param string $dbms - the DBMS name (e.g. mysql or sqlite)
	 * @return array
	 */
	protected function getDbmsClassNames($dbms)
	{ 
		return array
		(
			"Mephex_Db_Sql_Pdo_CredentialFactory_{$dbms}",
			$dbms
		);
	}
}