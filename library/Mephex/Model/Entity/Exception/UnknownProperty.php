<?php



/**
 * An exception thrown when an undefined entity property is accessed. 
 * 
 * @author mlight
 */
class Mephex_Model_Entity_Exception_UnknownProperty
extends Mephex_Exception
{
	/**
	 * The entity the property was being looked for in.
	 * 
	 * @var Mephex_Model_Entity
	 */
	protected $_entity;
	
	/**
	 * The name of the property being looked for.
	 * 
	 * @var string
	 */
	protected $_property_name;
	
	
	
	/**
	 * @param $entity - the entity in use
	 * @param $property_name - the property name that was being accessed
	 */
	public function __construct(Mephex_Model_Entity $entity, $property_name)
	{
		parent::__construct("The provided entity does not have a '{$property_name}' property");
		
		$this->_entity			= $entity;
		$this->_property_name	= $property_name;
	}
	
	
	
	/**
	 * Getter for entity.
	 * 
	 * @return Mephex_Model_Entity
	 */
	public function getEntity()
	{
		return $this->_entity;
	}
	
	
	
	/**
	 * Getter for property name.
	 * 
	 * @return string
	 */
	public function getPropertyName()
	{
		return $this->_property_name;
	}
}