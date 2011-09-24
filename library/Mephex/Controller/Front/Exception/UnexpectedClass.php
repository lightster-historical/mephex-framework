<?php



/**
 * An exception thrown when the front controller was expecting a class name
 * of a class that implements/extends the expected class, but received something
 * else.
 * 
 * @author mlight
 */
class Mephex_Controller_Front_Exception_UnexpectedClass
extends Mephex_Exception
{
	/**
	 * The class name the front controller was expecting
	 * the class to implement/extend.
	 * @var string
	 */
	protected $_expected_class;

	/**
	 * The class the front controller received
	 * @var string
	 */
	protected $_passed_class;
	
	
	
	/**
	 * @param string $expected_class - the name of the class that the front
	 *		controller was expecting the class to implement/extend.
	 * @param string $passed_class - the class the front controller received
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