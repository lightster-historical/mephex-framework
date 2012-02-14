<?php



/**
 * Holds a list of application resources and resource loaders.
 * 
 * @author mlight
 */
class Mephex_App_Resource_List
{
	/**
	 * An associative array holding the class name (value) for the type name
	 * (key).
	 *
	 * @var string[]
	 */
	protected $_type_classes;

	/**
	 * An associative array holding the Mephex_Reflection_Class (value)
	 * for the type name (key).
	 *
	 * @var Mephex_Reflection_Class[]
	 */
	protected $_type_class_reflections;

	/**
	 * An associative array holding the Mephex_Reflection_Class (value) 
	 * for the class name (key).
	 *
	 * @var Mephex_Reflection_Class[]
	 */
	protected $_class_reflections;


	/**
	 * A multi-dimensional associative array holding a list of resources
	 * organized by type name and resource name.
	 *
	 * @var object[][]
	 */
	protected $_resources;

	/**
	 * An associative array holding the Mephex_App_Resource_Loader (value)
	 * for the type name (key).
	 *
	 * @var Mephex_App_Resource_Loader[]
	 */
	protected $_loaders;




	public function __construct()
	{
		$this->_type_classes			= array();
		$this->_type_class_reflections	= array();
		$this->_class_reflections		= array();

		$this->_resources				= array();
		$this->_loaders					= array();
	}



	/**
	 * Adds a resource loader, associating it with the given type.
	 *
	 * @param string $type_name - the type name to associate the loader with
	 * @param Mephex_App_Resource_Loader $loader - the loader to use for the type
	 * @return void
	 */
	public function addLoader($type_name, Mephex_App_Resource_Loader $loader)
	{
		$this->addType($type_name, $loader->getResourceClassName());

		$this->_loaders[$type_name]	= $loader;
	}



	/**
	 * Adds a type that with the provided class name as the expected resource
	 * type.
	 *
	 * @param string $type_name - the type name to add
	 * @param string $class_name - the class name that resources associated
	 *		with this type are expected to be.
	 * @return void
	 */
	public function addType($type_name, $class_name)
	{
		if(array_key_exists($type_name, $this->_type_classes))
		{
			throw new Mephex_App_Resource_Exception_DuplicateType($this, $type_name);
		}

		if(!array_key_exists($class_name, $this->_class_reflections))
		{
			$this->_class_reflections[$class_name]	= new Mephex_Reflection_Class(
				$class_name
			);
		}

		$this->_type_classes[$type_name]			= $class_name;
		$this->_type_class_reflections[$type_name]
			= $this->_class_reflections[$class_name];
		$this->_resources[$type_name]				= array();
	}



	/**
	 * Checks to see if the given class extends the class that the resource type
	 * is associated with.
	 *
	 * @param string $type_name - the type name to check
	 * @param string $class_name - the class name to check the resource type's
	 *		class against
	 * @return string
	 */
	public function checkType($type_name, $class_name)
	{
		if(!array_key_exists($type_name, $this->_type_class_reflections))
		{
			throw new Mephex_App_Resource_Exception_UnknownType($this, $type_name);
		}

		return $this->_type_class_reflections[$type_name]
			->checkClassInheritance($class_name);
	}



	/**
	 * Adds a resource to the list.
	 *
	 * @param string $type_name - the type name to associate the resource with
	 * @param string $resource_name - the resource name to associate the
	 *		resource with
	 * @param object $resource - the resource
	 * @return void
	 */
	public function addResource($type_name, $resource_name, $resource)
	{
		if(!array_key_exists($type_name, $this->_type_class_reflections))
		{
			throw new Mephex_App_Resource_Exception_UnknownType($this, $type_name);
		}

		$this->_resources[$type_name][$resource_name]
			= $this->_type_class_reflections[$type_name]->checkObjectType($resource);

		return $this;
	}



	/**
	 * Attempts to load a resource from the type's resource loader, if one
	 * exists.
	 *
	 * @param string $type_name - the type name of the resource
	 * @param string $resource_name - the resource name that needs to be loaded
	 * @return object
	 */
	protected function loadResource($type_name, $resource_name)
	{
		if(!array_key_exists($type_name, $this->_loaders))
		{
			throw new Mephex_App_Resource_Exception_UnknownLoader($this, $type_name);
		}

		return $this->_loaders[$type_name]->loadResource($resource_name);
	}



	/**
	 * Retrieves the resource associated with the given type and resource name.
	 *
	 * @param string $type_name - the type name the resource is associated with
	 * @param string $resource_name - the resource name to retrieve
	 * @return object
	 */
	public function getResource($type_name, $resource_name)
	{
		if(!array_key_exists($type_name, $this->_resources))
		{
			throw new Mephex_App_Resource_Exception_UnknownType($this, $type_name);
		}

		if(!array_key_exists($resource_name, $this->_resources[$type_name]))
		{
			$this->addResource(
				$type_name,
				$resource_name,
				$this->loadResource($type_name, $resource_name)
			);
		}

		return $this->_resources[$type_name][$resource_name];
	}



	/**
	 * Checks to see if the resource implements/extends the given class
	 *
	 * @param string $type_name - the type name the resource is associated with
	 * @param string $resource_name - the resource name to check and retrieve
	 * @param string $class_name - the class name to check the resource type's
	 *		class against
	 * @return object
	 */
	public function checkResourceType($type_name, $resource_name, $class_name)
	{
		$resource		= $this->getResource($type_name, $resource_name);
		$resource_class	= new Mephex_Reflection_Class($class_name);
		return $resource_class->checkObjectType($resource);
	}
}