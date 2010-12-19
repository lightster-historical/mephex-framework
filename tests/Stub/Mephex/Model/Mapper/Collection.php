<?php



class Stub_Mephex_Model_Mapper_Collection
extends Mephex_Model_Mapper
{
	public function getMappedEntity($data)
	{
		$entity	= new Stub_Mephex_Model_Entity_Collection();
		
		return $entity;
	}
	
	
	
	public function processNewEntity(Mephex_Model_Entity $entity, $data)
	{
		return $entity;
	}
	
	
	
	public function getMappedData(Mephex_Model_Entity $entity)
	{
		return array
		(
			'parentId'	=> ($entity->getParent() ? $entity->getParent->getId() : null)
		);	
	}	
}