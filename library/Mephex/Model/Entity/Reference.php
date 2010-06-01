<?php



/**
 * A placeholder that references an entity that is not yet loaded.
 * 
 * @author mlight
 */
class Mephex_Model_Entity_Reference
{
	/**
	 * The reader that the entity can be loaded from.
	 * @var Mephex_Model_Accessor_Reader
	 */
	private $_reader;
	
	/**
	 * The criteria needed to loaded the entity.
	 * @var Mephex_Model_Criteria
	 */
	private $_criteria;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Reader $reader
	 * @param Mephex_Model_Criteria $criteria
	 */
	public function __construct(Mephex_Model_Accessor_Reader $reader, Mephex_Model_Criteria $criteria)
	{
		$this->_reader		= $reader;
		$this->_criteria	= &$criteria;
	}
	
	
	
	/**
	 * Retrieves the entity.
	 * 
	 * @return Mephex_Model_Entity
	 */
	public function getEntity()
	{
		return $this->_reader->read($this->_criteria);
	}
	
	
	
	/**
	 * Getter for reader.
	 * 
	 * @return Mephex_Model_Accessor_Reader
	 */
	public function getReader()
	{
		return $this->_reader;
	}
	
	
	
	/**
	 * Getter for criteria.
	 * 
	 * return Mephex_Model_Criteria
	 */
	public function getCriteria()
	{
		return $this->_criteria;
	}
}