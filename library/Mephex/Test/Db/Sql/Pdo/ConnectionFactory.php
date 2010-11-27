<?php



/**
 * Generates a PDO connection for testing
 * based on options provided in a config option set. 
 * 
 * @author mlight
 */
class Mephex_Test_Db_Sql_Pdo_ConnectionFactory
extends Mephex_Db_Sql_Pdo_ConnectionFactory
{
	/**
	 * Generates an instance of the default credential factory.
	 * 
	 * @return Mephex_Db_Sql_Pdo_CredentialFactory
	 */
	protected function getDefaultCredentialFactory()
	{
		return new Mephex_Test_Db_Sql_Pdo_CredentialFactory();
	}
}