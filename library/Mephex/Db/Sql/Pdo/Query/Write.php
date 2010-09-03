<?php



/**
 * A database query that supports communication with a
 * master/writable database server via a PDO-powered connection.
 * 
 * @author mlight
 */
class Mephex_Db_Sql_Pdo_Query_Write
extends Mephex_Db_Sql_Pdo_Query
{	
	/**
	 * Retrieves the PDO connection to use for this particular query.
	 * 
	 * @return PDO
	 */
	protected function getPdoConnection()
	{
		return $this->_connection->getWriteConnection();
	}
}