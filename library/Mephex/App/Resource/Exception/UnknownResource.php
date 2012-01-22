<?php



/**
 * An exception thrown when a resource of the given name has not been added.
 * 
 * @author mlight
 */
class Mephex_App_Resource_Exception_UnknownResource
extends Mephex_Exception
{
	/**
	 * The resource loader that the exception resulted from.
	 * 
	 * @var Mephex_App_Resource_Loader
	 */
	protected $_resource_loader;
	
	/**
	 * The resource name that does not exist.
	 * 
	 * @var string
	 */
	protected $_resource_name;
	
	
	
	/**
	 * @param Mephex_App_Resource_Loader $resource_loader - the resource loader
	 *		that the exception resulted from
	 * @param string $resource_name - the resource name that could not be found
	 */
	public function __construct(Mephex_App_Resource_Loader $resource_loader, $resource_name)
	{
		parent::__construct("Resource '{$resource_name}' does not exist in the resource loader.");
		
		$this->_resource_loader	= $resource_loader;
		$this->_resource_name	= $resource_name;
	}
	
	
	
	/**
	 * Getter for resource loader.
	 * 
	 * @return Mephex_App_Resource_Loader
	 */
	public function getResourceLoader()
	{
		return $this->_resource_loader;
	}
	
	
	
	/**
	 * Getter for resource name.
	 * 
	 * @return string
	 */
	public function getResourceName()
	{
		return $this->_resource_name;
	}
}