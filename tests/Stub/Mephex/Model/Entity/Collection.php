<?php



class Stub_Mephex_Model_Entity_Collection
extends Mephex_Model_Entity_Collection
{
	protected $parent	= null;
	
	
	
	public function getParent()
	{
		return $this->getProperty('parent');
	}
	
	
	
	public function setParent($parent)
	{
		$this->setProperty('parent', $parent);
	}
	
	
	
	public function addChild($entity)
	{
		$this->add($entity);
	}
	
	
	
	public function getUniqueIdentifier()
	{
		return $this->getProperty('parent');
	}
}