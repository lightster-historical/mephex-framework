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
	
	
	
	/**
	 * Retrieves an array of values.
	 * 
	 * @param array $field_names - the array of criteria field names that
	 * 		values are being retrieved for
	 * @return array
	 */
	public function getCriteriaValues(array $field_names)
	{
		if(!$this->hasCriteriaFields($field_names))
		{
			throw new Mephex_Exception("Unknown criteria fields: '" . implode("', '", $field_names) . "'");
		}
		
		$values	= array();
		foreach($field_names as $field_name)
		{
			$values[$field_name]	= $this->getCriteriaValue($field_name);
		}
		
		return $values;
	}
}