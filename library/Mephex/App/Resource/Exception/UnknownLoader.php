<?php



/**
 * An exception thrown when a type of the given name does not have a resource
 * loader associated with it.
 * 
 * @author mlight
 */
class Mephex_App_Resource_Exception_UnknownLoader
extends Mephex_Exception
{
	/**
	 * The resource list that the exception resulted from.
	 * 
	 * @var Mephex_App_Resource_List
	 */
	protected $_resource_list;
	
	/**
	 * The type that does not have a resource loader associated with it.
	 * 
	 * @var string
	 */
	protected $_type_name;

	/**
	 * The resource name that does not exist.
	 * 
	 * @var string
	 */
	protected $_resource_name;
	
	
	
	/**
	 * @param Mephex_App_Resource_List $resource_list - the resource list that
	 *		the exception resulted from
	 * @param string $type_name - the type that does not have a resource loader
	 *		associated with it
	 * @param string $resource_name - the resource name that could not be found
	 */
	public function __construct(
		Mephex_App_Resource_List $resource_list, $type_name, $resource_name
	)
	{
		parent::__construct(
			"Type '{$type_name}' does not exist in the resource list"
			. " (attempting to load resource named '{$resource_name}')."
		);
		
		$this->_resource_list	= $resource_list;
		$this->_type_name		= $type_name;
		$this->_resource_name	= $resource_name;
	}
	
	
	
	/**
	 * Getter for resource list.
	 * 
	 * @return Mephex_App_Resource_List
	 */
	public function getResourceList()
	{
		return $this->_resource_list;
	}
	
	
	
	/**
	 * Getter for type name.
	 * 
	 * @return string
	 */
	public function getTypeName()
	{
		return $this->_type_name;
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