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
	 * @param Mephex_App_Resource_List $resource_list - the resource list that
	 *		the exception resulted from
	 * @param string $type_name - the type that does not have a resource loader
	 *		associated with it
	 */
	public function __construct(Mephex_App_Resource_List $resource_list, $type_name)
	{
		parent::__construct("Type '{$type_name}' does not exist in the resource list.");
		
		$this->_resource_list	= $resource_list;
		$this->_type_name		= $type_name;
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
}