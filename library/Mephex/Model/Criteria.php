<?php



/**
 * Container for holding criteria used to determine which entity
 * to load.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Criteria
{
	/**
	 * Determines if the criteria has values available for the
	 * given list of field names..
	 * 
	 * @param array $field_names
	 * @return bool
	 */
	public abstract function hasCriteriaFields(array $field_names);
	
	
	
	/**
	 * Retrieves the value for the given field name.
	 * 
	 * @param string $field_name
	 * @return mixed
	 */
	public abstract function getCriteriaValue($field_name);
}