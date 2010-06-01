<?php



/**
 * Accessor base class used for reader, writer, and
 * eraser accessor classes.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Accessor
{
	/**
	 * The accessor group this accesor belongs to. 
	 * 
	 * @var Mephex_Model_Accessor_Group
	 */
	private $_accessor_group;
	
	/**
	 * The mapper used for mapping data between a storage stream
	 * and an entity. 
	 * 
	 * @var Mephex_Model_Mapper
	 */
	private $_mapper;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $accessor_group
	 * @param Mephex_Model_Mapper $mapper
	 */
	public function __construct(
		Mephex_Model_Accessor_Group $accessor_group,
		Mephex_Model_Mapper $mapper
	)
	{
		$this->_accessor_group	= $accessor_group;
		$this->_mapper			= $mapper;	
	}
	
	
	
	/**
	 * Getter for accessor group.
	 * 
	 * @return Mephex_Model_Accessor_Group
	 */
	protected function getAccessorGroup()
	{
		return $this->_accessor_group;
	}
	
	
	
	/**
	 * Getter for mapper.
	 * 
	 * @return Mepehx_Model_Mapper
	 */
	protected function getMapper()
	{
		return $this->_mapper;
	}
}