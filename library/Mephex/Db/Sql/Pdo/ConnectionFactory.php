<?php



/**
 * Generates a PDO connection based on a credential factory and
 * credential names.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_ConnectionFactory
implements
	Mephex_Db_Sql_Base_ConnectionFactory,
	Mephex_App_Resource_Loader
{
	/**
	 * The credential factory that should be used for generating credentials
	 * based on connection names.
	 *
	 * @var Mephex_Db_Sql_Base_CredentialFactory
	 */
	protected $_credential_factory;



	/**
	 * @param Mephex_Db_Sql_Base_CredentialFactory $credential_factory -
	 *		the credential factory that should be used for generating
	 *		credentials based on connection names
	 */
	public function __construct(
		Mephex_Db_Sql_Base_CredentialFactory $credential_factory
	)
	{
		$this->_credential_factory	= $credential_factory;
	}



	/**
	 * Generates a database connection of the given name.
	 * 
	 * @param string $name - the name of the connection to generate
	 * @return Mephex_Db_Sql_Pdo_Connection
	 * @see Mephex_Db_Sql_Base_ConnectionFactory#getConnection
	 */
	public function getConnection($name)
	{
		return new Mephex_Db_Sql_Pdo_Connection(
			$this->_credential_factory->getCredential($name)
		);
	}



	/**
	 * Returns the name of the class that all resources from this loader
	 * will implement/extend.
	 *
	 * @return string
	 * @see Mephex_App_Resource_Loader#getResourceClassName
	 */
	public function getResourceClassName()
	{
		return 'Mephex_Db_Sql_Pdo_Connection';
	}



	/**
	 * Loads the resource with the given resource name.
	 *
	 * @param string $resource_name - the name of the resource to load
	 * @return object
	 * @see Mephex_App_Resource_Loader#loadResource
	 */
	public function loadResource($resource_name)
	{
		return $this->getConnection($resource_name);
	}
}