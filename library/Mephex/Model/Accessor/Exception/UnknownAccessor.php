<?php



/**
 * An exception thrown when an unknown accessor is requested.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Accessor_Exception_UnknownAccessor
extends Mephex_Exception
{
	/**
	 * The accessor group that the accessor was being requested from.
	 * @var Mephex_Model_Accessor_Group
	 */
	protected $_group;
	
	/**
	 * The name of the accessor being requested.
	 * @var string
	 */
	protected $_accessor_name;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $group - the group that 
	 * 		the accessor was being requested from
	 * @param $accessor_name - the accessor name being requested
	 */
	public function __construct(Mephex_Model_Accessor_Group $group, $accessor_name)
	{
		parent::__construct("'{$accessor_name}' is not a register accessor.");
		
		$this->_group			= $group;
		$this->_accessor_name	= $accessor_name;
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
}