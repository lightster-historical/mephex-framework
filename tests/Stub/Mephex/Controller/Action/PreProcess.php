<?php



class Stub_Mephex_Controller_Action_PreProcess
extends Stub_Mephex_Controller_Action
{
	protected function processPostAction()
	{
		parent::processPostAction();
		throw new Stub_Mephex_Controller_Action_Exception_PreProcessTestException();
	}
	
	
	
	public function serveIndex()
	{
		parent::serveIndex();
		throw new Stub_Mephex_Controller_Action_Exception_PreProcessTestException();
	}
}