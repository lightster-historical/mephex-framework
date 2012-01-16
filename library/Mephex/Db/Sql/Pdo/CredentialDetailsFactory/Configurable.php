<?php



/**
 * Generates credential details for a connection using a config option set. 
 * 
 * @author mlight
 */
abstract class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable
implements Mephex_Db_Sql_Pdo_CredentialDetailsFactory
{
	/**
	 * The config option set that the database credentials are stored in.
	 *
	 * @var Mephex_Config_OptionSet
	 */
	protected $_config;

	/**
	 * The config group in the config option set to look for the credentials in.
	 *
	 * @var string
	 */
	protected $_group;



	/**
	 * @param Mephex_Config_OptionSet $config - the config option set that the
	 *		the database credentials are stored in
	 * @param string - the config group in the config option set to look for
	 *		the credentials in
	 */
	public function __construct(Mephex_Config_OptionSet $config, $group)
	{
		$this->_config	= $config;
		$this->_group	= $group;
	}
}