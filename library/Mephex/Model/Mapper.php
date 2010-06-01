<?php



/**
 * Mapper used to map data between a storage system
 * and an entity (standardized object).
 * 
 * @author mlight
 */
abstract class Mephex_Model_Mapper
{
	/**
	 * The group that the accessor using this mapper belongs to.
	 * 
	 * @var Mephex_Model_Accessor_Group
	 */
	protected $_accessor_group; 
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $group - the group that the
	 * 		accessor using this mapper belongs to
	 */
	public function __construct(Mephex_Model_Accessor_Group $group)
	{
		$this->_accessor_group	= $group;
	}
	
	
	
	/**
	 * Getter for accessor group.
	 * 
	 * @return Mephex_Model_Accessor_Group
	 */
	public function getAccessorGroup()
	{
		return $this->_accessor_group;
	}
	
	
	
	/**
	 * Converts data from a storage system to a standardized
	 * object entity.
	 * 
	 * @param $data
	 * @return Mephex_Model_Entity
	 */
	public abstract function getMappedEntity($data);
	
	
	
	/**
	 * Converts an entity into data that a storage system
	 * can store (via a stream writer).
	 *  
	 * @param Mephex_Model_Entity $entity
	 * @return array
	 */
	public abstract function getMappedData(Mephex_Model_Entity $entity);
}