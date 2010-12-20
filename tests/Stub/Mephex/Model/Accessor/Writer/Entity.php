<?php



class Stub_Mephex_Model_Accessor_Writer_Entity
extends Mephex_Model_Accessor_Writer_Entity
{
	// making protected methods public
	public function getStream()
		{return parent::getStream();}
	public function getCache()
		{return parent::getCache();}
	public function generateData(Mephex_Model_Entity $entity) 
		{return parent::generateData($entity);}
}