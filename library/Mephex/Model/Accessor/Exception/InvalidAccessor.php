<?php



/**
 * An exception thrown when a generic (non-reader, -writer, -eraser)
 * accessor is registered.
 * 
 * @author mlight
 */
class Mephex_Model_Accessor_Exception_InvalidAccessor
extends Mephex_Exception
{
	/**
	 * The accessor group that the accessor was being registered in.
	 * @var Mephex_Model_Accessor_Group
	 */
	protected $_group;
	
	/**
	 * The name of the accessor being registered.
	 * @var string
	 */
	protected $_accessor_name;
	
	/**
	 * The accessor being registered.
	 * @var Mephex_Model_Accessor
	 */
	protected $_accessor;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $group - the group that 
	 * 		the accessor was being registered in
	 * @param $accessor_name - the accessor name being registered
	 * @param Mephex_Model_Accessor $accessor - the accessor being registered
	 */
	public function __construct(Mephex_Model_Accessor_Group $group, $accessor_name, Mephex_Model_Accessor $accessor)
	{
		parent::__construct("A generic (non-reader, -writer, -eraser) accessor cannot be registered.");
		
		$this->_group			= $group;
		$this->_accessor_name	= $accessor_name;
		$this->_accessor		= $accessor;
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
	 * Getter for accessor name.
	 * 
	 * @return string
	 */
	public function getAccessorName()
	{
		return $this->_accessor_name;
	}
	
	
	
	/**
	 * Getter for accessor.
	 * 
	 * @return Mephex_Model_Accessor
	 */
	public function getAccessor()
	{
		return $this->_accessor;
	}
}