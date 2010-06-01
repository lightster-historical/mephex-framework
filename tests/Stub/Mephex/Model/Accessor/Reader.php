<?php



class Stub_Mephex_Model_Accessor_Reader
extends Mephex_Model_Accessor_Reader
{
	// making protected methods public
	public function getStream()
		{return parent::getStream();}
	public function getCache()
		{return parent::getCache();}
		
		
		
	public function generateEntity(Mephex_Model_Criteria $criteria, Iterator $iterator) 
	{		
		return $this->getMapper()->getMappedEntity($iterator->current());
	}
}