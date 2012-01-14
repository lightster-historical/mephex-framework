<?php



/**
 * A database credential set that provides enough information to make
 * read/write PDO database connections and escape queries.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Credential
implements Mephex_Db_Sql_Base_Credential
{
	/**
	 * @param Mephex_Db_Sql_Quoter $quoter - the quoter used for escaping SQL
	 *		query values, fields, and table names
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $write_credential - the 
	 *		credential to use for making a write connection
	 * @param Mephex_Db_Sql_Pdo_CredentialDetails $read_credential - the 
	 *		credential to use for making a read connection
	 */
	public function __construct(
		Mephex_Db_Sql_Quoter $quoter,
		Mephex_Db_Sql_Pdo_CredentialDetails $write_credential,
		Mephex_Db_Sql_Pdo_CredentialDetails $read_credential
	)
	{
		$this->_quoter				= $quoter;
		$this->_write_credential	= $write_credential;
		$this->_read_credential		= $read_credential;
	}



	/**
	 * Returns a quoter, which is responsible for quoting table names,
	 * column names, and values.
	 *
	 * @return Mephex_Db_Sql_Quoter
	 * @see Mephex_Db_Sql_Base_Credential#getQuoter
	 */
	public function getQuoter()
	{
		return $this->_quoter;
	}



	/**
	 * Getter for write credential.
	 *
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	public function getWriteCredential()
	{
		return $this->_write_credential;
	}



	/**
	 * Getter for read credential.
	 *
	 * @return Mephex_Db_Sql_Pdo_CredentialDetails
	 */
	public function getReadCredential()
	{
		return $this->_read_credential;
	}
}