<?php



/**
 * Manages database connections that are generated from a config option set.
 * 
 * @author mlight
 */
class Mephex_Db_ConnectionManager_Configurable
extends Mephex_Db_ConnectionManager
{
	/**
	 * The configuration option set to use.
	 *
	 * @var Mephex_Config_OptionSet
	 */
	private $_config;

	/**
	 * Array of database connection config info.
	 *
	 * @var array
	 */
	private $_db_config_info		= array();

	/**
	 * Array of lazy-loaded connection factories.
	 *
	 * @var Mephex_Db_ConnectionFactory[]
	 */
	private $_connection_factories	= array();



	/**
	 * @param Mephex_Config_OptionSet $config - the config option set to use
	 */
	public function __construct(
		Mephex_Config_OptionSet $config
	)
	{
		$this->_config				= $config;
	}



	/**
	 * Lazy-loading getter for connection factory.
	 *
	 * @param string $group - the config option set group name that the
	 *		connection factory is needed for
	 * @return Mephex_Db_ConnectionFactory
	 */
	public function getConnectionFactory($group)
	{
		if(!array_key_exists($group, $this->_connection_factories))
		{
			$this->_connection_factories[$group]	
				= $this->generateDefaultConnectionFactory($group);
		}

		return $this->_connection_factories[$group];
	}



	/**
	 * Generates a default connection factory for the given config group.
	 *
	 * @return Mephex_Db_ConnectionFactory
	 */
	protected function generateDefaultConnectionFactory($group)
	{
		return new Mephex_Db_ConnectionFactory();
	}



	/**
	 * Sets the connection factory to use for the given config group.
	 *
	 * @param string $group - the config group to use the connection factory with
	 * @param Mephex_Db_ConnectionFactory $conn_factory - the connection factory
	 *		to use for the config group
	 * @return void
	 */
	public function setConnectionFactory(
		$group, Mephex_Db_ConnectionFactory $conn_factory
	)
	{
		$this->_connection_factories[$group]	= $conn_factory;
	}



	/**
	 * Adds a list of database connections that is defined as an array in
	 * config option value.
	 *
	 * @param string $group - the config group that the connection list is in
	 * @param string $option - the config option that the connection list is in
	 * @return void
	 */
	public function addConnectionList($group, $option)
	{
		$list	= $this->_config->get($group, $option);
		if(!is_array($list))
		{
			throw new Mephex_Db_ConnectionManager_Exception_InvalidConfigConnectionList
			(
				$this,
				$group,
				$option,
				$list
			);
		}

		foreach($list as $conn_option)
		{
			$this->addConnection($group, $conn_option);
		}
	}



	/**
	 * Adds a database connection that is defined in as a config option
	 *
	 * @param string $group - the config group that the connection params are in
	 * @param string $option - the config option that the connection params are in
	 * @return void
	 */
	public function addConnection($group, $option)
	{
		$nickname	= $this->getConnectionNickname(
			$this->_config,
			$group,
			$option
		);
		$this->_db_config_info[$nickname]	= array(
			'group'		=> $group,
			'option'	=> $option
		);
	}



	/**
	 * Determines a connection nickname based on the config group and option
	 *
	 * @param Mephex_Config_OptionSet $config - the config option set to use
	 * @param string $group - the config group that the connection params are in
	 * @param string $option - the config option that the connection params are in
	 * @return string
	 */
	protected function getConnectionNickname(
		Mephex_Config_OptionSet $config, $group, $option
	)
	{
		return $config->hasOption($group, $option . '.nickname')
			? $config->get($group, $option . '.nickname')
			: "{$group}.{$option}";
	}



	/**
	 * Generates the database connection that has the given name.
	 *
	 * @param string $name - the name of the connection
	 * @return Mephex_Db_Sql_Base_Connection
	 * @see Mephex_Db_ConnectionManager#generateConnection
	 */
	protected function generateConnection($name)
	{
		if(!array_key_exists($name, $this->_db_config_info))
		{
			throw new Mephex_Db_ConnectionManager_Exception_UnregisteredConnection
			(
				$this,
				$name
			);
		}

		$conn_factory	= $this->getConnectionFactory(
			$this->_db_config_info[$name]['group']
		);

		return $conn_factory->connectUsingConfig(
			$this->_config,
			$this->_db_config_info[$name]['group'],
			$this->_db_config_info[$name]['option']
		);
	}
}