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
		$credential_factory	= $this->_credential_factory;

		try
		{
			// try to get a 'write' credential (which can be used for
			// writing and reading)
			$write_credential	= $credential_factory->getCredential(
				"{$name}.write"
			);
			
			try
			{
				// try to get a 'read' credential (which can only be used for
				// reading)
				$read_credential	= $credential_factory->getCredential(
					"{$name}.read"
				);
			}
			catch(Mephex_Config_OptionSet_Exception_UnknownKey $read_ex)
			{
				// if a 'read' credential could not be loaded, we use
				// a null credential (which causes the 'write' connection to be 
				// used)
				$read_credential	= null;
			}
		}
		catch(Mephex_Config_OptionSet_Exception_UnknownKey $write_ex)
		{
			try
			{
				// if a 'write' credential could not be loaded (which also means
				// a 'read' credential was not loaded), attempt to load a general
				// credential
				$write_credential	= $credential_factory->getCredential(
					"{$name}"
				);
				$read_credential	= null;
			}
			catch(Mephex_Config_OptionSet_Exception_UnknownKey $general_ex)
			{
				// if a general credential could not be loaded, throw the
				// exception generated by attemptingto load the 'write' credential
				throw $write_ex;
			}
		}
		
		return $this->connectUsingCredentials(
			new Mephex_Db_Sql_Base_Quoter_Mysql(),
			$write_credential,
			$read_credential
		);
	}
	
	
	
	
	/**
	 * Generates a connection using the given credentials.
	 * 
	 * @param Mephex_Db_Sql_Quoter $quoter - the quoter used for escaping SQL
	 *		query values, fields, and table names
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $write_credential
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $read_credential
	 * @return Mephex_Db_Sql_Pdo_Connection
	 */
	protected function connectUsingCredentials(
		Mephex_Db_Sql_Quoter $quoter,
		Mephex_Db_Sql_Pdo_CredentialDetails $write_credential,
		Mephex_Db_Sql_Pdo_CredentialDetails $read_credential = null
	)
	{
		return new Mephex_Db_Sql_Pdo_Connection(
			$quoter,
			$write_credential,
			$read_credential
		);
	}
}