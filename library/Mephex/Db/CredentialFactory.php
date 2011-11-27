<?php



/**
 * Interface for credential factories to implement.
 *
 * @author mlight
 */
interface Mephex_Db_CredentialFactory
{
	public function getCredential($name);
}