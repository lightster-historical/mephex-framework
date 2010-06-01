<?php



/**
 * Accessor for reading collections using a secondary mapper
 * and secondary cache. The secondary mapper and secondary
 * cache are used to instantiate a secondary reader,
 * which uses the primary accessor group and a passthru stream
 * reader as its accessor group and stream reader.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Accessor_Reader_Collection_Basic
extends Mephex_Model_Accessor_Reader_Collection
{
	/**
	 * @param Mephex_Model_Accessor_Group $accessor_group
	 * @param Mephex_Model_Mapper $mapper
	 * @param Mephex_Model_Cache $cache
	 * @param Mephex_Model_Stream_Reader $stream
	 * @param Mephex_Model_Mapper $secondary_mapper
	 */
	public function __construct(
		Mephex_Model_Accessor_Group $accessor_group,
		Mephex_Model_Mapper $mapper,
		Mephex_Model_Cache $cache,
		Mephex_Model_Stream_Reader $stream,
		Mephex_Model_Mapper $secondary_mapper,
		Mephex_Model_Cache $secondary_cache
	)
	{ 
		$secondary_reader	= new Mephex_Model_Accessor_Reader_Entity
		(
			$accessor_group,
			$secondary_mapper,
			$secondary_cache,
			new Mephex_Model_Stream_Reader_Passthru()
		);
		
		parent::__construct(
			$accessor_group, $mapper, $cache, $stream, $secondary_reader
		);
		
		$this->_secondary_reader	= $secondary_reader;
	}
}