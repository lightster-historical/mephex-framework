<?php



/**
 * Wraps an associative array of objects in a resource loader.
 *
 * @author mlight
 */
class Mephex_App_Resource_Loader_ArrayWrapper
implements Mephex_App_Resource_Loader
{
	/**
	 * The name of the class that all resources from this loader
	 * will implement/extend.
	 *
	 * @var string
	 */
	protected $_class_name;

	/**
	 * An associative array holding the resource object (value) for the 
	 * resource name (key).
	 *
	 * @var object[]
	 */
	protected $_resources;



	/**
	 * @var string $class_name - the name of the class that all resources
	 *		from this loader will implement/extend
	 * @var array $resources - an associative array holding the resource 
	 *		object (value) for the resource name (key).
	 */
	public function __construct($class_name, array $resources)
	{
		$this->_class_name	= $class_name;
		$this->_resources	= $resources;
	}



	/**
	 * Returns the name of the class that all resources from this loader
	 * will implement/extend.
	 *
	 * @return string
	 * @see Mephex_App_Resource_Loader#getClassName
	 */
	public function getClassName()
	{
		return $this->_class_name;
	}



	/**
	 * Loads the resource with the given resource name.
	 *
	 * @param string $resource_name - the name of the resource to load
	 * @return object
	 * @see Mephex_App_Resource_Loader#loadResource
	 */
	public function loadResource($resource_name)
	{
		if(!array_key_exists($resource_name, $this->_resources))
		{
			throw new Mephex_App_Resource_Exception_UnknownResource($this, $resource_name);
		}

		return $this->_resources[$resource_name];
	}
}