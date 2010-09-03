<?php



/**
 * A database query that supports communication with a
 * slave/readable database server via a PDO-powered connection.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Query_Read
extends Mephex_Db_Sql_Pdo_Query
{	
	/**
	 * Retrieves the PDO connection to use for this particular query.
	 * 
	 * @return PDO
	 */
	protected function getPdoConnection()
	{
		return $this->_connection->getReadConnection();
	}
}