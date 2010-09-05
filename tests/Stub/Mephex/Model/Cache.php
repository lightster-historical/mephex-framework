<?php



class Stub_Mephex_Model_Cache
extends Mephex_Model_Cache
{
	// implementing abstract methods
	public function remember(Mephex_Model_Entity $entity)
	{
		$this->getCache()->remember("Id:{$entity->getId()}", $entity);
	}
	
	
	
	public function forget(Mephex_Model_Entity $entity)
	{
		$this->getCache()->forget("Id:{$entity->getId()}");
	}
	
	
	
	protected function generateKeyFromCriteria(Mephex_Model_Criteria $criteria)
	{
		if($criteria->hasCriteriaFields(array('Id')))
		{
			return "Id:{$criteria->getCriteriaValue('Id')}";
		}
		
		return null;
	}
	
	
	
	// making protected methods public
	public function getCache()
		{return parent::getCache();}
}