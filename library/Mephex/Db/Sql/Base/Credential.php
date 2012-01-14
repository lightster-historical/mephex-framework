<?php



/**
 * A database credential set that provides enough information to make
 * a database connection and escape queries.
 * 
 * @author mlight
 */
interface Mephex_Db_Sql_Base_Credential
{
	public function getQuoter();
}