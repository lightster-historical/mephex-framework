<?php



/**
 * A database credential set that provides enough information to make
 * a database connection and escape queries.
 * 
 * @author mlight
 */
interface Mephex_Db_Sql_Base_Credential
{
	/**
	 * Returns a quoter, which is responsible for quoting table names,
	 * column names, and values.
	 *
	 * @return Mephex_Db_Sql_Base_Quoter
	 */
	public function getQuoter();
}