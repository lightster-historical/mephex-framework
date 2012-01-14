<?php



/**
 * Interface for credential factories to implement.
 *
 * @author mlight
 */
interface Mephex_Db_Sql_Base_CredentialFactory
{
	/**
	 * Generates the credential of the given name.
	 *
	 * @param string $name - the name of the credential to generate
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	public function getCredential($name);
}