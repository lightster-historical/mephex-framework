<?php



/**
 * An exception thrown when an entity of an unexpected type is checked
 * with Mephex_Model_Entity#checkEntityType()
 * 
 * @author mlight
 */
class Mephex_Model_Exception_UnexpectedEntityType
extends Mephex_Exception
{
	/**
	 * The entity that was having its type checked. 
	 * @var Mephex_Model_Entity
	 */
	protected $_entity;
	
	/**
	 * The class name the entity was expected to be.
	 * @var string
	 */
	protected $_class_name;
	
	
	
	/**
	 * @param Mephex_Model_Entity $entity - the entity being checked
	 * @param $class_name - the class name that the entity must be an
	 * 		instance of
	 */
	public function __construct(Mephex_Model_Entity $entity, $class_name)
	{
		parent::__construct("The provided entity is not an instance of '{$class_name}'");
		
		$this->_entity		= $entity;
		$this->_class_name	= $class_name;
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
	 * Getter for class name.
	 * 
	 * @return string
	 */
	public function getClassName()
	{
		return $this->_class_name;
	}
}