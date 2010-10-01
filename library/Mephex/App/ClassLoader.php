<?php



/**
 * Abstract class loader.
 * 
 * @author mlight
 */
abstract class Mephex_App_ClassLoader
{
	/**
	 * Loads the class of the given name.
	 * 
	 * @param string $class_name
	 * @return bool
	 */
	public abstract function loadClass($class_name);
}