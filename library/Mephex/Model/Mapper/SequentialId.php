<?php



/**
 * Mapper used to map data between a storage system with sequential ids
 * and an entity (standardized object).
 * 
 * @author mlight
 */
abstract class Mephex_Model_Mapper_SequentialId
extends Mephex_Model_Mapper
{
	/**
	 * Updates a new entity the first time after it is saved. This is useful 
	 * for updating properties that have their values automatically updated.
	 * 
	 * @param Mephex_Model_Entity $entity
	 * @param mixed $data
	 * @return Mephex_Model_Entity
	 */
	public function processNewEntity(Mephex_Model_Entity $entity, $data)
	{
		return $entity->setId($data);
	}
}