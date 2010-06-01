<?php



/**
 * Criteria that holds a unique identifier and a raw record from a 
 * reader stream. 
 * 
 * @author mlight
 */
class Mephex_Model_Criteria_StreamReader_Id
extends Mephex_Model_Criteria_StreamReader
{
	/**
	 * Raw reader stream record.
	 * 
	 * @var mixed
	 */
	protected $_data;
	
	/**
	 * The unique identifier.
	 * 
	 * @var mixed
	 */
	protected $_id;
	
	
	
	/**
	 * @param mixed $data
	 * @param mixed $id
	 */
	public function __construct($data, $id)
	{
		$this->_data	= $data;
		$this->_id		= $id;
	}
	
	
	
	/**
	 * Getter for the raw reader stream record.
	 * 
	 * @return mixed
	 */
	public function getStreamReaderData()
	{
		return $this->_data;
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
		return ($field_names == array('Id'));	
	}
	
	
	
	/**
	 * Retrieves the unique identifier value.
	 * 
	 * @param string $field_name
	 * @return mixed
	 */
	public function getCriteriaValue($field_name)
	{
		return $this->_id;
	}
}