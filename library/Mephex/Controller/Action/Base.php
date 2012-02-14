<?php



/**
 * Controller for grouping similar actions/processes
 * with base implementation.
 * 
 * @author mlight
 */
abstract class Mephex_Controller_Action_Base
implements Mephex_Controller_Action
{
	/**
	 * The resource list containing necessary resources.
	 *
	 * @var Mephex_App_Resource_List
	 */
	private $_resource_list;



	/**
	 * @param Mephex_App_Resource_List $resource_list
	 */
	public function __construct(Mephex_App_Resource_List $resource_list)
	{
		$this->_resource_list	= $resource_list;
	}
	
	
	
	/**
	 * Runs the given action and the pre/post action processes.
	 * 
	 * @param string $action_name - the action that is being requested
	 * @return void
	 */
	public function runAction($action_name)
	{
		$this->processPreAction();
		
		$this->processAction($action_name);
		
		$this->processPostAction();
	}
	
	
	
	/**
	 * Runs pre-processing that should occur before any action.
	 * 
	 * @return void
	 */
	protected function processPreAction()
	{
	}
	
	
	
	/**
	 * Runs pre-processing that should occur after any action.
	 * 
	 * @return void
	 */
	protected function processPostAction()
	{
	}
	
	
	
	/**
	 * Runs the actual action.
	 * 
	 * @param unknown_type $action_name
	 * @return void
	 * @throws Mephex_Controller_Action_Exception_ActionNotFound
	 * @throws Mephex_Controller_Action_Exception_ActionNotAccessible
	 */
	protected function processAction($action_name)
	{
		$method_name	= $this->getActionMethodName($action_name);
		
		if(!method_exists($this, $method_name))
		{
			throw new Mephex_Controller_Action_Exception_ActionNotFound($this, $method_name, $action_name);
		}
		else if(!is_callable(array($this, $method_name)))
		{
			throw new Mephex_Controller_Action_Exception_ActionNotAccessible($this, $method_name, $action_name);
		}
		
		$this->{$method_name}();
	}
	
	
	
	/**
	 * Generates the action method name.
	 * 
	 * @param string $action_name
	 * @return void
	 */
	protected function getActionMethodName($action_name)
	{
		return "serve{$action_name}";
	}



	/**
	 * Getter for resource list.
	 *
	 * @return Mephex_App_ResourceList
	 */
	protected function getResourceList()
	{
		return $this->_resource_list;
	}
}