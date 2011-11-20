<?php



/**
 * Holds widely-used application objects (e.g. application arguments,
 * config option sets)
 * 
 * @author mlight
 */
class Mephex_App_ResourceList
{
	/**
	 * The cache that holds the 
	 *
	 * @var Mephex_Cache_Object
	 */
	private $_cache;

	/**
	 * Lazy-loaded array of reflection classes.
	 *
	 * @var Mephex_Reflection_Class[]
	 */
	private $_reflection_classes	= array();



	public function __construct()
	{
		$this->_cache	= new Mephex_Cache_Object();
	}



	/**
	 * Adds a resource to the resource list.
	 *
	 * @param string $key - the key to remember the resource by
	 * @param Mephex_App_Resource $resource - the resource to remember
	 * @return void
	 */
	public function add($key, Mephex_App_Resource $resource)
	{
		$this->_cache->remember($key, $resource);
	}



	/**
	 * Lazy-loading getter for reflection classes.
	 *
	 * @param string $class - the name of the class to get the reflection class
	 *		for
	 * @return Mephex_App_Resource
	 */
	protected function getReflectionClass($class)
	{
		if(!array_key_exists($class, $this->_reflection_classes)) {
			$this->_reflection_classes[$class]	
				= new Mephex_Reflection_Class($class);
		}

		return $this->_reflection_classes[$class];
	}



	/**
	 * Retrieves the resource from the list and checks to make sure it
	 * implements/extends the given interface/class.
	 *
	 * @param string $key - the key of the resource to retrieve
	 * @param string $class - the name of the interface/class the resource
	 *		is expected to be an instance of
	 * @return void
	 */
	public function get($key, $class)
	{
		$reflection	= $this->getReflectionClass($class);
		return $reflection->checkObjectType(
			$this->_cache->find($key)
		);
	}
}