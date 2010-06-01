<?php



/**
 * Reader used to load a record from a storage system 
 * before mapping it to an entity.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Stream_Reader
{
	/**
	 * Reads the records that meet the specified criteria
	 * from the storage system.
	 * 
	 * @param array $criteria
	 * @return Iterator - an iterator used to 
	 */
	public abstract function read(Mephex_Model_Criteria $criteria);
}  