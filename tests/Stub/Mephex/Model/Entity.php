<?php



class Stub_Mephex_Model_Entity
extends Mephex_Model_Entity
{
	protected $id				= null;
	protected $parent			= null;
	protected $referenceOnly	= null;
	
	
	
	public function getUniqueIdentifier()
	{
		return $this->getId();
	}
	
	
	
	public function isReferencedPropertyAllowed($name)
	{
		if($name == 'parent'
			|| $name == 'referenceOnly')
		{
			return true;
		}
		
		return parent::isReferencedPropertyAllowed($name);
	}
	
	
	
	public function getId()
	{
		return $this->getProperty('id');
	}
	
	
	
	public function setId($id)
	{
		$this->setProperty('id', $id);
		
		return $this;
	}
	
	
	
	public function getParent()
	{
		return $this->getProperty('parent');
	}
	
	
	
	public function setParent($parent)
	{
		$this->setProperty('parent', $parent);
		
		return $this;
	}
	
	
	
	public function getReferenceOnly()
	{
		return $this->getProperty('referenceOnly');
	}
	
	
	
	public function getUndefinedProperty()
	{
		return $this->getProperty('undefined');
	}
	
	
	
	public function setUndefinedProperty($value)
	{
		$this->setProperty('undefined', $value);
		
		return $this;
	}
}