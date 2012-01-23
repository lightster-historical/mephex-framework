<?php



/**
 * Generates a testing Sqlite credential based on a file path connection name.
 * 
 * @author mlight
 */
class Mephex_Test_Db_Sql_Pdo_CredentialFactory_Sqlite
implements Mephex_Db_Sql_Base_CredentialFactory
{
	/**
	 * The temp file copier to use for copying the SQLite databases.
	 *
	 * @var Mephex_Test_TmpFileCopier
	 */
	private $_tmp_copier;



	/**
	 * @param Mephex_Test_TmpFileCopier $tmp_copier - the temp file copier
	 *		to use for copying the SQLite databases
	 */
	public function __construct(Mephex_Test_TmpFileCopier $tmp_copier)
	{
		$this->_tmp_copier	= $tmp_copier;
	}




	/**
	 * Get the credential with the given file path connection name.
	 *
	 * @param string $name - the file path connection name
	 * @return Mephex_Db_Sql_Pdo_Credential
	 * @see Mephex_Db_Sql_Base_CredentialFactory#getCredential
	 */
	public function getCredential($name)
	{
		$database_copy	= $this->_tmp_copier->copy($name);

		$details	= $this->getCredentialDetails($database_copy);

		return new Mephex_Db_Sql_Pdo_Credential(
			new Mephex_Db_Sql_Base_Quoter_Sqlite(),
			$details,
			$details
		);
	}



	/**
	 * Get the credential details with the given file path connection name.
	 *
	 * @param string $name - the file path connection name
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	protected function getCredentialDetails($name)
	{
		$dsn		= "sqlite:{$name}";
		$options	= array(
			PDO::ATTR_TIMEOUT => 1.0
		);

		return new Mephex_Db_Sql_Pdo_CredentialDetails($dsn, null, null, $options);
	}
}