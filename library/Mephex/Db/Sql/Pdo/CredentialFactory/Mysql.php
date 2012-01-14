<?php



/**
 * Generates a credential for a MySQL connection using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialFactory_Mysql
extends Mephex_Db_Sql_Pdo_CredentialFactory_Dbms
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	
	/**
	 * Generates a credential for a MySQL connection using a config option set,
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
		$username	= $config->get($group, "{$connection_name}.username", null, false);
		$password	= $config->get($group, "{$connection_name}.password", null, false);
		$database	= $config->get($group, "{$connection_name}.database");
		
		$host	= null;
		$port	= null;
		$socket	= null;
		
		try
		{
			$host	= $config->get($group, "{$connection_name}.host");
			$port	= $config->get($group, "{$connection_name}.port", null, false);
		}
		catch(Mephex_Exception $ex)
		{
			try
			{
				$socket	= $config->get($group, "{$connection_name}.socket");
			}
			catch(Mephex_Exception $second_ex)
			{
				throw $ex;
			}
		}
		
		$parts	= array();
		
		if($host)
		{
			$parts[]	= "host={$host}";
			if($port)
			{
				$parts[]	= "port={$port}";
			}
		}
		else if($socket)
		{
			$parts[]	= "unix_socket={$socket}";
		}
		
		$parts[]	= "dbname={$database}";
		
		return new Mephex_Db_Sql_Pdo_CredentialDetails(
			'mysql:' . implode(';', $parts), 
			$username,
			$password
		);
	}
}