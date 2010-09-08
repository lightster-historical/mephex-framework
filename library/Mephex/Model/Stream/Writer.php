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
	 * Writes the given records.
	 * 
	 * @param $data
	 * @return bool 
	 */
	public abstract function write($data);
}  