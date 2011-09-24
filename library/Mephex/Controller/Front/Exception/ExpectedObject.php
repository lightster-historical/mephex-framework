<?php



/**
 * An exception thrown when the front controller was expecting an instance
 * of a specific class but received something else.
 * 
 * @author mlight
 */
class Mephex_Controller_Front_Exception_ExpectedObject
extends Mephex_Exception
{
	/**
	 * The class name the front controller was expecting
	 * the object to be.
	 * @ar string
	 */
	protected $_expected_class;

	/**
	 * The value the front contoller received.
	 * @var mixed
	 */
	protected $_passed_value;
	
	
	
	/**
	 * @param string $expected_class - the name of the class that the front
	 *		controller was expecting an object to be
	 * @param mixed $passed_value - the actual value passed
	 */
	public function __construct($expected_class, $passed_value)
	{
		parent::__construct("Object of class '{$expected_class}' expected.");
		
		$this->_expected_class	= $expected_class;
		$this->_passed_value	= $passed_value;
	}
	
	
	
	/**
	 * Getter for expected class.
	 * 
	 * @return string
	 */
	public function getExpectedClass()
	{
		return $this->_expected_class;
	}



	/**
	 * Getter for passed value.
	 *
	 * @return mixed
	 */
	public function getPassedValue()
	{
		return $this->_passed_value;
	}
}