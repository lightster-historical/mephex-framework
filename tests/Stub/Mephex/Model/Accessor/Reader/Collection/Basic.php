<?php



class Stub_Mephex_Model_Accessor_Reader_Collection_Basic
extends Mephex_Model_Accessor_Reader_Collection_Basic
{
	public $unit_test_entities;
	
	
	
	// making protected methods public
	public function getSecondaryReader()
		{return parent::getSecondaryReader();}
	public function generateEntity(Mephex_Model_Criteria $criteria, Iterator $iterator)
		{return parent::generateEntity($criteria, $iterator);}
	
	
	
	// implementing abstract methods
	public function generateSecondaryCriteria($data)
	{
		return new Mephex_Model_Criteria_StreamReader_Id($data, $data['id']);
	}
	
	
	
	protected function addEntity(Mephex_Model_Entity_Collection $collection, Mephex_Model_Entity $entity)
	{
		$this->unit_test_entities[]	= $entity;
	}
}