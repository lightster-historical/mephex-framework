<?php



/**
 * Accessor for writing an entity.
 * 
 * @author mlight
 */
class Mephex_Model_Accessor_Writer_Entity
extends Mephex_Model_Accessor_Writer
{
	/**
	 * Generates raw data from an entity so that it 
	 * can be passed to a stream writer.
	 * 
	 * @param Mephex_Model_Entity $entity
	 */
	protected function generateData(Mephex_Model_Entity $entity) 
	{
		return $this->getMapper()->getMappedData($entity);
	}
}