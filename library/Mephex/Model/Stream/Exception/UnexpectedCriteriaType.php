<?php



/**
 * An exception thrown when a criteria of an unexpected type is
 * passed as a function parameter.
 * 
 * @author mlight
 */
class Mephex_Model_Stream_Exception_UnexpectedCriteriaType
extends Mephex_Exception
{
	/**
	 * The reader stream being used.
	 * @var Mephex_Model_Stream_Reader
	 */
	protected $_reader;
	
	/**
	 * The criteria passed to the reader.
	 * @var Mephex_Model_Criteria
	 */
	protected $_criteria;
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_class_name;
	
	
	
	/**
	 * @param $reader - the reader being used
	 * @param $criteria - the criteria passed in
	 * @param $class_name - the class name the criteria is expected to implement
	 */
	public function __construct(Mephex_Model_Stream_Reader $reader, Mephex_Model_Criteria $criteria, $class_name)
	{
		parent::__construct("The provided criteria is not an instance of {$class_name}");
		
		$this->_reader		= $reader;
		$this->_criteria	= $criteria;
		$this->_class_name	= $class_name;
	}
	
	
	
	/**
	 * Getter for reader.
	 * 
	 * @return Mephex_Model_Stream_Reader
	 */
	public function getReader()
	{
		return $this->_reader;
	}
	
	
	
	/**
	 * Getter for criteria.
	 * 
	 * @return Mephex_Model_Criteria
	 */
	public function getCriteria()
	{
		return $this->_criteria;
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