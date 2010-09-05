<?php



/**
 * An abstract result set iterator. 
 * 
 * @author mlight
 */
abstract class Mephex_Db_Sql_Base_ResultSet
implements Iterator
{
	/**
	 * Retrieves the autoincrement id of the first row from the most recent insert.
	 * 
	 * @return int
	 */
	public function getLastInsertId()
	{
		throw new Mephex_Db_Exception("getLastInsertId() is not supported by this database wrapper.");
	}
}