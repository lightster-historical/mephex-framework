<?php



/**
 * An exception thrown when an entity property is set to a Reference
 * when not allowed.
 * 
 * @author mlight
 */
class Mephex_Model_Exception_UnallowedReference
extends Mephex_Exception
{
	/**
	 * The entity in which the property is being set for.
	 * @var Mephex_Model_Entity
	 */
	protected $_entity;
	
	/**
	 * The name of the property being set.
	 * @var string
	 */
	protected $_property_name;
	
	/**
	 * The reference the entity's property was being set to.
	 * @var Mephex_Model_Entity_Reference
	 */
	protected $_reference;
	
	
	
	/**
	 * @param Mephex_Model_Entity $entity - the entity being modified
	 * @param $property_name - the name of the property being set
	 * @param Mephex_Model_Entity_Reference $reference - the reference
	 * 		the entity's property was being set to
	 */
	public function __construct(Mephex_Model_Entity $entity, $property_name, Mephex_Model_Entity_Reference $reference)
	{
		parent::__construct("Entity property '{$property_name} cannot be set to a reference.");
		
		$this->_entity			= $entity;
		$this->_property_name	= $property_name;
		$this->_reference		= $reference;
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
	
	
	
	/**
	 * Getter for reference.
	 * 
	 * @return Mephex_Model_Entity_Reference
	 */
	public function getReference()
	{
		return $this->_reference;
	}
}