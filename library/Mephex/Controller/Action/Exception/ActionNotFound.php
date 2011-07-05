<?php



/**
 * An exception that is thrown when a requested controller action does not exist.
 * 
 * @author mlight
 */
class Mephex_Controller_Action_Exception_ActionNotFound
extends Mephex_Exception
{
	/**
	 * The controller which is supposed to have the accessible action.
	 * @var Mephex_Controller_Action
	 */
	private $_controller;
	
	/**
	 * The name of the action method that is inaccessible.
	 * @var string
	 */
	private $_method_name;
	
	/**
	 * The name of the action being accessed.
	 * @var string
	 */
	private $_action_name;
	
	
	
	
	/**
	 * @param Mephex_Controller_Action $controller - the controller in which
	 * 		the action was being searched for
	 * @param string $method_name - the method name that was searched for
	 * @param string $action_name - the action name that was being search for
	 * @param string $message - a custom exception message to use
	 */
	public function __construct(Mephex_Controller_Action $controller, $method_name, $action_name, $message = null) 
	{
		if(!$message)
		{
			$message	= "Controller '" . get_class($controller) 
				. "' does not contain method '{$method_name}' for '{$action_name}' action.";
		}
		
		parent::__construct($message);
		
		$this->_controller	= $controller;
		$this->_method_name	= $method_name;
		$this->_action_name	= $action_name;
	}
	
	
	
	/**
	 * Getter for controller.
	 * 
	 * @return Mephex_Controller_Action
	 */
	public function getController()
	{
		return $this->_controller;
	}
	
	
	
	/**
	 * Getter for method name.
	 * 
	 * @return string
	 */
	public function getMethodName()
	{
		return $this->_method_name;
	}
	
	
	
	/**
	 * Getter for action name.
	 * 
	 * @return string
	 */
	public function getActionName()
	{
		return $this->_action_name;
	}
}