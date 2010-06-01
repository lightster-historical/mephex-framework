<?php



/**
 * An exception thrown when a cache is registered for a specific
 * entity class when a cache has already been registered for the
 * entity class.
 * 
 * @author mlight
 */
class Mephex_Model_Accessor_Exception_DuplicateEntityCache
extends Mephex_Exception
{
	/**
	 * The accessor group that the cache was being registered for.
	 * @var Mephex_Model_Accessor_Group
	 */
	protected $_group;
	
	/**
	 * The name of the class the cache was being registered for
	 * @var string
	 */
	protected $_class_name;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $group - the group that 
	 * 		the duplicate cache was being registered for
	 * @param $class_name - the entity class name that already had
	 * 		a cache registered
	 */
	public function __construct(Mephex_Model_Accessor_Group $group, $class_name)
	{
		parent::__construct("Entity class '{$class_name}' already has a registered cache.");
		
		$this->_group		= $group;
		$this->_class_name	= $class_name;
	}
	
	
	
	/**
	 * Getter for accessor group.
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