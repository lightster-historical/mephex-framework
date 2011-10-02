<?php



class Stub_Mephex_Controller_Front_Base
extends Mephex_Controller_Front_Base
{
	private $_action_ctrl_name;
	private $_action_name;



	public function __construct($action_ctrl_name, $action_name)
	{
		parent::__construct();

		$this->_action_ctrl_name	= $action_ctrl_name;
		$this->_action_name	= $action_name;
	}



	public function getActionControllerClassName()
	{
		return $this->_action_ctrl_name;
	}

	public function getActionControllerActionName()
	{
		return $this->_action_name;
	}
	
	
	
	public function generateDefaultRouter()
	{
		return new Stub_Mephex_Controller_Router_Front($this);
	}



	// make protected methods public for unit testing purposes
	public function getRouter()
		{return parent::getRouter();}
	public function getActionController()
		{return parent::getActionController();}
	public function generateActionController($class_name)
		{return parent::generateActionController($class_name);}
	public function runAction(
		Mephex_Controller_Action $action_controller,
		$action_name
	)
	{
		return parent::runAction($action_controller, $action_name);
	}
	public function checkObjectInheritance($object, $expected)
		{return parent::checkObjectInheritance($object, $expected);}
	public function checkClassInheritance($class, $expected)
		{return parent::checkClassInheritance($class, $expected);}
}