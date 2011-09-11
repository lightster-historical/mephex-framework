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
	 * The lazy-loaded action controller.
	 *
	 * @var Mephex_Controller_Action_Base
	 */
	protected $_action_controller	= null;



	public function __construct()
	{
	}
	
	

	/**
	 * The router to use for determining the action controller and action
	 * name to run.
	 *
	 * @return Mephex_Controller_Router
	 */	
	protected abstract function getRouter();
	
	
	
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
	 * Lazy-loading getter for the action controller.
	 *
	 * @return Mephex_Controller_Action_Base
	 */
	protected function getActionController()
	{
		if(null === $this->_action_controller)
		{
			$this->_action_controller	= $this->generateActionController(
				$this->getRouter()->getClassName()
			);
		}

		return $this->_action_controller;
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