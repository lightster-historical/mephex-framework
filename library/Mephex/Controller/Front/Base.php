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
	protected $_router	= null;


	/**
	 * The lazy-loaded action controller.
	 *
	 * @var Mephex_Controller_Action_Base
	 */
	protected $_action_controller	= null;



	public function __construct()
	{
	}
	
	
	
	/**
	 * Runs the application.
	 *
	 * @Return void
	 */
	public function run()
	{
		$router	= $this->getRouter();
		
		return $this->runAction(
			$this->getActionController(),
			$this->getRouter()->getActionName()
		);
	}
	
	

	/**
	 * The router to use for determining the action controller and action
	 * name to run.
	 *
	 * @return Mephex_Controller_Router
	 */	
	protected abstract function generateRouter();



	/**
	 * Lazy-loading getter for the router.
	 *
	 * @return Mephex_Controller_Router
	 */
	protected function getRouter()
	{
		if(null === $this->_router)
		{
			$expected	= new Mephex_Reflection_Class(
				'Mephex_Controller_Router'
			);
			$this->_router	= $expected->checkObjectType(
				$this->generateRouter()
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
		return new $class_name($this);
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