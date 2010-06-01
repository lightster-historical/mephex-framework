<?php



/**
 * Container for holding an array of criteria used to determine 
 * which entity (or entities) to load.
 * 
 * @author mlight
 */
class Mephex_Model_Criteria_Array
extends Mephex_Model_Criteria
{
	/**
	 * Associative array of criteria
	 * 
	 * @var array of key/value criteria
	 */
	protected $_criteria;
	
	
	
	/**
	 * @param array $criteria - an associative array of criteria.
	 */
	public function __construct(array $criteria)
	{
		$this->_criteria	= &$criteria;
	}
	
	
	
	/**
	 * Determines if the criteria has values available for the
	 * given list of field names..
	 * 
	 * @param array $field_names
	 * @return bool
	 */
	public function hasCriteriaFields(array $field_names)
	{
		return count(array_diff($field_names, array_keys($this->_criteria))) == 0;
	}
	
	
	
	/**
	 * Retrieves the value for the given field name.
	 * 
	 * @param string $field_name
	 * @return mixed
	 */
	public function getCriteriaValue($field_name)
	{
		return $this->_criteria[$field_name];
	}
}