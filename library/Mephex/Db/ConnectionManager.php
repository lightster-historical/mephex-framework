<?php



/**
 * Manages database connections.
 * 
 * @author mlight
 */
abstract class Mephex_Db_ConnectionManager
{
	/**
	 * Array of lazy-loaded database connections.
	 *
	 * @return array
	 */
	private $_connections	= array();



	/**
	 * Generates the database connection that has the given name.
	 *
	 * @param string $name - the name of the connection
	 * @return Mephex_Db_Sql_Base_Connection
	 */
	protected abstract function generateConnection($name);



	/**
	 * Lazy-loads and returns the connection that has the given name.
	 *
	 * @param string $name - the name of the connection
	 * @return Mephex_Db_Sql_Base_Connection
	 */
	public function getConnection($name)
	{
		if(!array_key_exists($name, $this->_connections))
		{
			$this->_connections[$name]	= $this->generateConnection($name);
		}

		return $this->_connections[$name];
	}
}