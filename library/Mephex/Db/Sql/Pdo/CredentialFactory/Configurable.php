<?php



/**
 * Generates a credential for a given DBMS using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialFactory_Configurable
implements Mephex_Db_Sql_Base_CredentialFactory
{
	/**
	 * The config option set that the database credentials are stored in.
	 *
	 * @var Mephex_Config_OptionSet
	 */
	private $_config;

	/**
	 * The config group in the config option set to look for the credentials in.
	 *
	 * @var string
	 */
	private $_group;


	/**
	 * Reflection class for Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable.
	 *
	 * @var Mephex_Reflection_Class
	 */
	private $_credential_reflection_class;



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

		$this->_credential_reflection_class	= new Mephex_Reflection_Class(
			'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable'
		);
	}




	/**
	 * Get the credential with the given name.
	 *
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_Credential
	 * @see Mephex_Db_Sql_Base_CredentialFactory#getCredential
	 */
	public function getCredential($name)
	{
		$factory		= $this->getDetailsFactory($name);
		$quoter			= $factory->getQuoter($name);

		if($this->_config->get($this->_group, "{$name}.enable_dual", false))
		{
			return $this->getDualCredential(
				$factory,
				$quoter,
				$name
			);
		}
		else
		{
			return $this->getSingularCredential(
				$factory,
				$quoter,
				$name
			);
		}
	}



	/**
	 * Get the factory for the given credential name
	 *
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_CredentialDetailsFactory
	 */
	protected function getDetailsFactory($name)
	{
		$dbms			= $this->_config->get($this->_group, "{$name}.dbms");
		$factory_class	= $this->getCredentialFactoryClassName($dbms);
		return new $factory_class($this->_config, $this->_group);
	}



	/**
	 * Generates a dual credential (i.e. a credential with read and write
	 * credentials that are different.)
	 *
	 * @param Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable $factory 
	 *		- the factory to use for generating the credential details
	 * @param Mephex_Db_Sql_Base_Quoter $quoter - the quoter to use when constructing
	 *		the credential
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_Credential
	 */
	protected function getDualCredential(
		Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable $factory,
		Mephex_Db_Sql_Base_Quoter $quoter,
		$name
	)
	{
		$write_credential	= $factory->getCredentialDetails("{$name}.write");
		$read_credential	= $factory->getCredentialDetails("{$name}.read");

		return new Mephex_Db_Sql_Pdo_Credential(
			$quoter,
			$write_credential,
			$read_credential
		);
	}



	/**
	 * Generates a singular credential (i.e. a credential with read and write
	 * credentials that are the same.)
	 *
	 * @param Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable $factory
	 *		- the factory to use for generating the credential details
	 * @param Mephex_Db_Sql_Base_Quoter $quoter - the quoter to use when constructing
	 *		the credential
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_Credential
	 */
	protected function getSingularCredential(
		Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable $factory,
		Mephex_Db_Sql_Base_Quoter $quoter,
		$name
	)
	{
		$credential	= $factory->getCredentialDetails($name);

		return new Mephex_Db_Sql_Pdo_Credential(
			$quoter,
			$credential,
			$credential
		);
	}
	
	
	
	/**
	 * Generates a list of possible credential details factory class names based
	 * for the DBMS name.
	 * 
	 * @param string $dbms - the DBMS name (e.g. mysql or sqlite)
	 * @return array
	 */
	protected function getCredentialFactoryClassNames($dbms)
	{
		return array
		(
			"Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_{$dbms}",
			$dbms
		);
	}



	/**
	 * Determines the credential detials factory class name for the given DBMS.
	 * 
	 * @param string $dbms - the DBMS name (e.g. Mysql or Sqlite)
	 * @return string
	 */
	protected function getCredentialFactoryClassName($dbms)
	{
		$classes	= $this->getCredentialFactoryClassNames($dbms);

		foreach($classes as $class)
		{
			if(class_exists($class))
			{
				return $this->_credential_reflection_class
					->checkClassInheritance($class);
			}
		}

		throw new Mephex_Db_Sql_Pdo_Exception_UnknownDbms(
			$this, $dbms, $classes
		);
	}
}