<?php



/**
 * An exception thrown when the front controller could not find a
 * system class.
 * 
 * @author mlight
 */
class Mephex_Controller_Front_Exception_NonexistentClass
extends Mephex_Exception
{
	/**
	 * The class or interface name the front controller was attempting to use.
	 * @var string
	 */
	protected $_class;
	
	
	
	/**
	 * @param string $class - the class the front controller was attempting to use.
	 */
	public function __construct($class)
	{
		parent::__construct("Class '{$class}' does not exist.");
		
		$this->_class	= $class;
	}
	
	
	
	/**
	 * Getter for class.
	 * 
	 * @return string
	 */
	public function getClass()
	{
		return $this->_class;
	}
}