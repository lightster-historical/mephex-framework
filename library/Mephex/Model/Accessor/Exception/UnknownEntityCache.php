<?php



/**
 * An exception thrown when an entity cache cannot be found for a
 * class.
 * 
 * @author mlight
 */
class Mephex_Model_Accessor_Exception_UnknownEntityCache
extends Mephex_Exception
{
	/**
	 * The accessor group that the cache was being requested from
	 * @var Mephex_Model_Accessor_Group
	 */
	protected $_group;
	
	/**
	 * The name of the class the cache was being requested for
	 * @var string
	 */
	protected $_class_name;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $group - the group that 
	 * 		the cache was expected to be in
	 * @param $class_name - the entity class name that a cache could
	 * 		not be found for
	 */
	public function __construct(Mephex_Model_Accessor_Group $group, $class_name)
	{
		parent::__construct("Entity class '{$class_name}' does not have a cache registered.");
		
		$this->_group		= $group;
		$this->_class_name	= $class_name;
	}
	
	
	
	/**
	 * Getter for entity.
	 * 
	 * @return Mephex_Model_Accessor_Group
	 */
	public function getAccessorGroup()
	{
		return $this->_group;
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