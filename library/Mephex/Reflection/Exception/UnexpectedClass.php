<?php



/**
 * An exception thrown when a child class name was expected but another class
 * was received.
 *
 * @author mlight
 */
class Mephex_Reflection_Exception_UnexpectedClass
extends Mephex_Exception
{
	/**
	 * The class name the child class was expected to extend/implement.
	 * @var string
	 */
	protected $_expected_class;

	/**
	 * The class that was being checked
	 * @var string
	 */
	protected $_passed_class;
	
	
	
	/**
	 * @param string $expected_class - the class name the child class was
	 *		expected to extend/implement
	 * @param string $passed_class - the class that was being checked
	 */
	public function __construct($expected_class, $passed_class)
	{
		parent::__construct("Class implementing/extending '{$expected_class}' expected.");
		
		$this->_expected_class	= $expected_class;
		$this->_passed_class	= $passed_class;
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
	 * Getter for passed class.
	 *
	 * @return string
	 */
	public function getPassedClass()
	{
		return $this->_passed_class;
	}
}