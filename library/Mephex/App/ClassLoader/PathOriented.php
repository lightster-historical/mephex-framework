<?php



require_once 'Mephex/App/ClassLoader.php';



/**
 * Class loader that loads the provided class name by converting
 * all underscores to directory separators (e.g. '/') and calling
 * require_once on the transformed class name.
 * 
 * @author mlight
 */
class Mephex_App_ClassLoader_PathOriented
extends Mephex_App_ClassLoader
{
	/**
	 * The prefix that the class name must begin with in order
	 * for the class loader to attempt to load the class.
	 * 
	 * @var string
	 */
	protected $_required_prefix;
	
	
	
	/**
	 * @param string $required_prefix - the prefix that the class 
	 * 	name must begin with in order for the class loader to 
	 * 	attempt to load the class
	 */
	public function __construct($required_prefix = null)
	{
		parent::__construct();
		
		$this->_required_prefix	= $required_prefix;
	}
	
	
	
	/**
	 * Loads the class of the given name if it meets the
	 * prefix requirement.
	 * 
	 * @param string $class_name - the class to load
	 * @return bool
	 */
	public function loadClass($class_name)
	{
		if(!$this->isPrefixRequirementMet($class_name))
		{
			return false;
		}
		
		$path	= str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
		
		if($this->includeExists($path))
		{
			include_once $path;
			return true;
		}
		
		return false;
	}
	
	
	
	/**
	 * Checks to see if the class name meets the prefix requirement.
	 * 
	 * @param string $class_name
	 * @return bool
	 */
	protected function isPrefixRequirementMet($class_name)
	{
		return empty($this->_required_prefix) 
			|| substr($class_name, 0, strlen($this->_required_prefix)) === $this->_required_prefix;
	}
}