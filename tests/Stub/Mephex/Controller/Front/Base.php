<?php



class Stub_Mephex_Controller_Front_Base
extends Mephex_Controller_Front_Base
{
	protected $_router;



	public function __construct(Mephex_Controller_Router $router)
	{
		parent::__construct();

		$this->_router	= $router;
	}
	
	
	
	public function getRouter()
	{
		return $this->_router;
	}



	// make protected methods public for unit testing purposes
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
}