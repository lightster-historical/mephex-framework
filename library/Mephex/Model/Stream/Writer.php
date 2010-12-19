<?php



/**
 * Writer used to write a record to a storage system 
 * after mapping it from an entity.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Stream_Writer
{
	/**
	 * Creates a new record using the given data.
	 * 
	 * @param $data
	 * @return bool 
	 */
	public abstract function create($data);
	
	/**
	 * Updates an existing record using the given data.
	 * 
	 * @param $data
	 * @return bool 
	 */
	public abstract function update($data);
}  