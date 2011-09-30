<?php



/**
 * An exception thrown when an instance of a specific class was expected but
 * something else was received.
 * 
 * @author mlight
 */
class Mephex_Reflection_Exception_ExpectedObject
extends Mephex_Exception
{
	/**
	 * The class name the object was expected to extend/implement.
	 * @ar string
	 */
	protected $_expected_class;

	/**
	 * The value that was received
	 * @var mixed
	 */
	protected $_passed_value;
	
	
	
	/**
	 * @param string $expected_class - class name the object was
	 * 		expected to extend/implement
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