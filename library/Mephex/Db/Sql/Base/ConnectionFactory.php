<?php



/**
 * Generates SQL-database connections based on connection names.
 * 
 * @author mlight
 */
interface Mephex_Db_Sql_Base_ConnectionFactory
{
	/**
	 * Generates a database connection of the given name.
	 * 
	 * @param string $name - the name of the connection to generate
	 * @return Mephex_Db_Sql_Pdo_Connection
	 */
	public function getConnection($name);
}