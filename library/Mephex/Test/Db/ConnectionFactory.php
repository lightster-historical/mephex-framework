<?php



/**
 * Generates a database connection for testing
 * based on options provided in a config option set. 
 * 
 * @author mlight
 */
class Mephex_Test_Db_ConnectionFactory
extends Mephex_Db_Sql_ConnectionFactory
{
	/**
	 * The temporary file copier responsible for copying temporary files.
	 * 
	 * @var Mephex_Test_TmpFileCopier
	 */
	protected $_tmp_copier;
	
	
	
	/**
	 * @param Mephex_Test_TmpFileCopier $tmp_copier - the temporary file copier
	 * 		to use for copying temporary files.
	 */
	public function __construct(Mephex_Test_TmpFileCopier $tmp_copier)
	{
		parent::__construct();
		
		$this->_tmp_copier	= $tmp_copier;
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
		$config->set($group, "{$connection_name}.tmp_copier", $this->_tmp_copier);
		
		return parent::connectUsingConfig($config, $group, $connection_name);
	}
	
	
	
	/**
	 * Generates a list of possible driver class names based on the driver name.
	 * 
	 * @param string $driver - the driver name (e.g. Pdo)
	 * @return array
	 */
	protected function getDriverClassNames($driver)
	{
		$classes	= parent::getDriverClassNames($driver);
		array_unshift($classes, "Mephex_Test_Db_Sql_{$driver}_ConnectionFactory");
		
		return $classes;
	}
}