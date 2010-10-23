<?php



class Stub_Mephex_Model_Mapper
extends Mephex_Model_Mapper
{
	public function getMappedEntity($data)
	{
		$entity	= new Stub_Mephex_Model_Entity();
		$entity->setId($data['id']);
		$entity->setParent($data['parent']);
		
		return $entity;
	}
	
	
	
	public function getMappedData(Mephex_Model_Entity $entity)
	{
		return array
		(
			'id'		=> $entity->getId(),
			'parentId'	=> ($entity->getParent() ? $entity->getParent()->getId() : null)
		);	
	}	
}