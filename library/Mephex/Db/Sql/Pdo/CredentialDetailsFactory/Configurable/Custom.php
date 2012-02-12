<?php



/**
 * Generates custom credential details for a connection using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Custom
extends Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable
{
	/**
	 * Reflection class for Mephex_Db_Sql_Base_Quoter
	 *
	 * @var Mephex_Reflection_Class
	 */
	private $_quoter_reflection_class;



	/**
	 * @param Mephex_Config_OptionSet $config - the config option set that the
	 *		the database credentials are stored in
	 * @param string - the config group in the config option set to look for
	 *		the credentials in
	 */
	public function __construct(Mephex_Config_OptionSet $config, $group)
	{
		parent::__construct($config, $group);

		$this->_quoter_reflection_class	= new Mephex_Reflection_Class(
			'Mephex_Db_Sql_Base_Quoter'
		);
	}



	/**
	 * Get the credential details with the given name.
	 *
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 * @see Mephex_Db_Sql_Pdo_CredentialDetailsFactory#getCredentialDetails
	 */
	public function getCredentialDetails($name)
	{
		$dsn		= $this->_config->get($this->_group, "{$name}.dsn");
		$username	= $this->_config->get($this->_group, "{$name}.username", null, false);
		$password	= $this->_config->get($this->_group, "{$name}.password", null, false);
		
		return new Mephex_Db_Sql_Pdo_CredentialDetails(
			$dsn, 
			$username,
			$password
		);
	}



	/**
	 * Generates the quoter for the given credential/connection name.
	 *
	 * @param string $name - the name of the credential/connection to generate
	 *		the quoter for
	 * @return Mephex_Db_Sql_Base_Quoter
	 * @see Mephex_Db_Sql_Pdo_CredentialDetailsFactory#getQuoter
	 */
	public function getQuoter($name)
	{
		$quoter_class	= $this->getQuoterClassName(
			$this->_config->get(
				$this->_group,
				"{$name}.quoter"
			)
		);

		return new $quoter_class();
	}



	/**
	 * Generates a list of possible quoter class names based for
	 * the quoter name.
	 * 
	 * @param string $name - the quoter name (e.g. Mysql or Sqlite)
	 * @return array
	 */
	protected function getQuoterClassNames($name)
	{
		return array
		(
			"Mephex_Db_Sql_Base_Quoter_{$name}",
			$name
		);
	}



	/**
	 * Determines the quoter class name.
	 * 
	 * @param string $name - the quoter name (e.g. Mysql or Sqlite)
	 * @return string
	 */
	protected function getQuoterClassName($name)
	{
		$classes	= $this->getQuoterClassNames($name);

		foreach($classes as $class)
		{
			if(class_exists($class))
			{
				return $this->_quoter_reflection_class
					->checkClassInheritance($class);
			}
		}

		throw new Mephex_Db_Sql_Pdo_Exception_UnknownQuoter(
			$this, $name, $classes
		);
	}
}