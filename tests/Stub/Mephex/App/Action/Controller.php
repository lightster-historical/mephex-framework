<?php



class Stub_Mephex_App_Action_Controller
extends Mephex_App_Action_Controller
{
	private $isPreActionProcessed	= false;
	private $isPostActionProcessed	= false;
	private $actionProcessed		= null;
	
	
	
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
	
	
	
	public function getActionMethodName($actionName)
		{return parent::getActionMethodName($actionName);}
}