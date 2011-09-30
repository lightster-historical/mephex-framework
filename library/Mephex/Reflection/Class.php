<?php



/**
 * Extension of PHP's ReflectionClass.
 *
 * @author mlight
 */
class Mephex_Reflection_Class
extends ReflectionClass
{
	/**
	 * @param string $class - the class to reflect on
	 */
	public function __construct($class)
	{
		if(!is_object($class)
			&& !class_exists($class)
			&& !interface_exists($class)
		)
		{
			throw new Mephex_Reflection_Exception_NonexistentClass($class);
		}

		parent::__construct($class);
	}



	/**
	 * Checks to see if a given object is an instance of class that
	 * extends/implements another class/interface, returning the original object
	 * upon success and throwing an exception otherwise.
	 *
	 * @param object $object - the object to check
	 * @return string - the passed class on success
	 * @throws Mephex_Controller_Front_Exception_NonexistentClass
	 * @throws Mephex_Controller_Front_Exception_ExpectedObject
	 */
	public function checkObjectType($object)
	{
		$expected	= $this->getName();
		if(!is_object($object) || !($object instanceof $expected))
		{
			throw new Mephex_Reflection_Exception_ExpectedObject(
				$this->getName(), $object
			);
		}

		return $object;
	}



	/**
	 * Checks to see if a given class extends/implements another 
	 * class/interface, returning the original class upon success and throwing
	 * an exception otherwise.
	 *
	 * @param string $class - the class to check
	 * @return string - the passed class on success
	 * @throws Mephex_Controller_Front_Exception_NonexistentClass
	 * @throws Mephex_Controller_Front_Exception_UnexpectedClass
	 */
	public function checkClassInheritance($class)
	{
		$to_check	= new self($class);
		$is_child		= ($this->isInterface()
			? $to_check->implementsInterface($this->getName())
			: $to_check->isSubclassOf($this->getName())
		);
		if(!$is_child)
		{
			throw new Mephex_Reflection_Exception_UnexpectedClass(
				$this->getName(), $class
			);
		}

		return $class;
	}
}