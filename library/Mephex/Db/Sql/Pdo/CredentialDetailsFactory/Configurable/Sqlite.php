<?php



/**
 * Generates credential details for a Sqlite connection using a config option set. 
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable_Sqlite
extends Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable
{
	/**
	 * Get the credential details with the given name.
	 *
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 * @see Mephex_Db_Sql_Pdo_CredentialDetailsFactory#getCredentialDetails
	 */
	public function getCredentialDetails($name)
	{
		$database	= $this->_config->get($this->_group, "{$name}.database");
		$dsn		= "sqlite:{$database}";
		$options	= array(
			PDO::ATTR_TIMEOUT => $this->_config->get($this->_group, "{$name}.timeout", 1.0)
		);
		
		return new Mephex_Db_Sql_Pdo_CredentialDetails($dsn, null, null, $options);
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
		return new Mephex_Db_Sql_Base_Quoter_Sqlite();
	}
}