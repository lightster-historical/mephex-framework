<?php



/**
 * Controller for determining and running the action in the action controller.
 * 
 * @author mlight
 */
abstract class Mephex_Controller_Front_Base
implements Mephex_Controller_Front
{
	/**
	 * The lazy-loaded router.
	 *
	 * @var Mephex_Controller_Router
	 */
	private $_router	= null;


	/**
	 * The lazy-loaded action controller.
	 *
	 * @var Mephex_Controller_Action_Base
	 */
	private $_action_controller	= null;


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
		return $this->runAction(
			$this->getActionController(),
			$this->getRouter()->getActionName()
		);
	}



	/**
	 * Runs the application with a router other than the default router.
	 *
	 * @param Mephex_controller_Router $router - the router to use
	 * @return void
	 */
	public function runWithRouterOverride(Mephex_Controller_Router $router)
	{
		$this->_router	= $router;

		return $this->run();
	}



	/**
	 * Lazy-loading getter for the router.
	 *
	 * @return Mephex_Controller_Router
	 */
	protected function getRouter()
	{
		if(null === $this->_router)
		{
			$this->_router	= $this->_resource_list->checkResourceType(
				'Router',
				'Default',
				'Mephex_Controller_Router'
			);
		}

		return $this->_router;
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
	 * Lazy-loading getter for the action controller.
	 *
	 * @return Mephex_Controller_Action_Base
	 */
	protected function getActionController()
	{
		if(null === $this->_action_controller)
		{
			$expected	= new Mephex_Reflection_Class(
				'Mephex_Controller_Action_Base'
			);
			$class_name	= $expected->checkClassInheritance(
				$this->getRouter()->getClassName()
			);
			$this->_action_controller	= $expected->checkObjectType(
				$this->generateActionController($class_name)
			);
		}

		return $this->_action_controller;
	}
	
	
	
	/**
	 * Runs the specified action in the action controller.
	 *
	 * @param Mephex_Controller_Action $action_controller - the action
	 *		controller to use
	 * @param string $action_name - the action name to run
	 * @return void
	 */
	protected function runAction(
		Mephex_Controller_Action $action_controller,
		$action_name
	)
	{
		return $action_controller->runAction($action_name);
	}
}