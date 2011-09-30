<?php



/**
 * An exception thrown when a class could not be found.
 * 
 * @author mlight
 */
class Mephex_Reflection_Exception_NonexistentClass
extends Mephex_Exception
{
	/**
	 * The name of the missing class or interface that was used.
	 * @var string
	 */
	protected $_class;
	
	
	
	/**
	 * @param string $class - the name of the missing class
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