<?php



/**
 * Controller for determining and running the action in the action controller.
 * 
 * @author mlight
 */
class Mephex_Controller_Front_Base
implements Mephex_Controller_Front
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
	 * Getter for resource list.
	 *
	 * @return Mephex_App_Resource_List
	 */
	public function getResourceList()
	{
		return $this->_resource_list;
	}
	
	
	
	/**
	 * Runs the application.
	 *
	 * @return void
	 */
	public function run()
	{
		$router				= $this->getRouter();
		$action_controller	= $this->getActionController($router);

		return $action_controller->runAction($router->getActionName());
	}



	/**
	 * Lazy-loading getter for the router.
	 *
	 * @return Mephex_Controller_Router
	 */
	protected function getRouter()
	{
		return $this->_resource_list->checkResourceType(
			'Router',
			'Default',
			'Mephex_Controller_Router'
		);
	}
	
	
	
	/**
	 * Generate an instance of the action controller specified by the
	 * given class name.
	 * 
	 * @param string $class_name - the action controller space name
	 * @return Mephex_Controller_Action_Base
	 */
	protected function generateActionController($class_name)
	{
		return new $class_name($this->_resource_list);
	}
	
	
	
	/**
	 * Getter for the action controller.
	 *
	 * @return Mephex_Controller_Action_Base
	 */
	protected function getActionController(Mephex_Controller_Router $router)
	{
		$expected	= new Mephex_Reflection_Class(
			'Mephex_Controller_Action_Base'
		);
		$class_name	= $expected->checkClassInheritance(
			$router->getClassName()
		);

		return $this->generateActionController($class_name);
	}
}