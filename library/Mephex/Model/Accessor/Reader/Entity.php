<?php



/**
 * Accessor for reading an entity.
 * 
 * @author mlight
 */
class Mephex_Model_Accessor_Reader_Entity
extends Mephex_Model_Accessor_Reader
{
	/**
	 * Generates an entity object using the criteria and the
	 * raw data (in the iterator) provided by the stream reader.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 * @param Iterator $iterator - an iterator containing the raw data
	 * @see Mephex_Model_Accessor_Reader#generateEntity
	 */
	protected function generateEntity(Mephex_Model_Criteria $criteria, Iterator $iterator)
	{
		$mapper	= $this->getMapper();
		foreach($iterator as $record)
		{
			return $mapper->getMappedEntity($record);
		}
		
		throw new Mephex_Model_Accessor_Exception_EmptyResultSet("The result set passed to the reader is empty.");
	}
}