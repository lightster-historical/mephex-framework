<?php



class Stub_Mephex_Model_Mapper_SequentialId
extends Mephex_Model_Mapper_SequentialId
{
	public function getMappedEntity($data)
	{
		return new Stub_Mephex_Model_Entity();
	}
	
	
	
	public function getMappedData(Mephex_Model_Entity $entity)
	{
		return array();
	}	
}