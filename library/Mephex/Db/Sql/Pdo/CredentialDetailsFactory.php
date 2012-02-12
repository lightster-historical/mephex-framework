<?php



/**
 * Interface for credential details factories to implement.
 *
 * @author mlight
 */
interface Mephex_Db_Sql_Pdo_CredentialDetailsFactory
{
	/**
	 * Get the credential details with the given name.
	 *
	 * @param string $name - the name of the credential/connection
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	public function getCredentialDetails($name);

	/**
	 * Generates the quoter for the given credential/connection name.
	 *
	 * @param string $name - the name of the credential/connection to generate
	 *		the quoter for
	 * @return Mephex_Db_Sql_Base_Quoter
	 */
	public function getQuoter($name);
}