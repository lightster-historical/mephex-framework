<?php



class Stub_Mephex_Controller_Action_Base
extends Mephex_Controller_Action_Base
{
	private $isPreActionProcessed	= false;
	private $isPostActionProcessed	= false;
	private $actionProcessed		= null;
	private $argumentsClass			= null;



	public function __construct(
		Mephex_Controller_Front_Base $front_ctrl,
		$args_class = null
	)
	{
		parent::__construct($front_ctrl);
		
		$this->argumentsClass	= 
			($args_class)	?	$args_class
							:	parent::getExpectedArgumentsClass();
	}
	
	
	
	protected function processPreAction()
	{
		parent::processPreAction();
		$this->isPreActionProcessed		= true;
	}
	
	
	
	protected function processPostAction()
	{
		parent::processPostAction();
		$this->isPostActionProcessed	= true;
	}
	
	
	
	public function isPreActionProcessed()
	{
		return $this->isPreActionProcessed;
	}
	
	
	
	public function isPostActionProcessed()
	{
		return $this->isPostActionProcessed;
	}
	
	
	
	public function getActionName()
	{
		return $this->actionProcessed;
	}	
	
	
	
	public function serveIndex()
	{
		$this->actionProcessed	= 'index';
	}
	
	
	
	public function serveList()
	{
		$this->actionProcessed	= 'list';
	}
	
	
	
	public function serveBuilder()
	{
		$this->actionProcessed	= 'builder';
	}
	
	
	
	private function serveInaccessible()
	{
		$this->actionProcessed	= 'inaccessible';
	}


	
	public function getExpectedArgumentsClass()
	{
		return $this->argumentsClass;
	}
	
	
	public function getActionMethodName($actionName)
		{return parent::getActionMethodName($actionName);}
	public function getFrontController()
		{return parent::getFrontController();}
	public function checkArguments(Mephex_App_Arguments $args)
		{return parent::checkArguments($args);}
}