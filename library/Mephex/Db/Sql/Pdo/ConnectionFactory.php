<?php



/**
 * Generates a PDO connection based on a credential factory and
 * credential names.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_ConnectionFactory
implements Mephex_Db_Sql_Base_ConnectionFactory
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
}