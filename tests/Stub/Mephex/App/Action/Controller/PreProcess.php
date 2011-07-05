<?php



class Stub_Mephex_App_Action_Controller_PreProcess
extends Stub_Mephex_App_Action_Controller
{
	protected function processPostAction()
	{
		parent::processPostAction();
		throw new Stub_Mephex_App_Action_Exception_PreProcessTestException();
	}
	
	
	
	public function serveIndex()
	{
		parent::serveIndex();
		throw new Stub_Mephex_App_Action_Exception_PreProcessTestException();
	}
}