<?php



class Stub_Mephex_Model_Accessor_Writer
extends Mephex_Model_Accessor_Writer
{
	// making protected methods public
	public function getStream()
		{return parent::getStream();}
	public function getCache()
		{return parent::getCache();}
		
		
		
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