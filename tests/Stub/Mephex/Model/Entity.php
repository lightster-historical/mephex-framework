<?php



class Stub_Mephex_Model_Entity
extends Mephex_Model_Entity
{
	protected $id				= null;
	protected $name				= null;
	protected $parent			= null;
	protected $referenceOnly	= null;
	
	
	
	public function setProperty($name, $value)	
		{return parent::setProperty($name, $value);}
	public function getProperties(array $properties)
		{return parent::getProperties($properties);}
	
	
	
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
		return $this->setProperty('id', $id);
	}
	
	
	
	public function getName()
	{
		return $this->getProperty('name');
	}
	
	
	
	public function setName($name)
	{
		return $this->setProperty('name', $name);
	}
	
	
	
	public function getParent()
	{
		return $this->getProperty('parent');
	}
	
	
	
	public function setParent($parent)
	{
		return $this->setProperty('parent', $parent);
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
		return $this->setProperty('undefined', $value);
	}
}