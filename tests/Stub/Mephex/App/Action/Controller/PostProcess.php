<?php



class Stub_Mephex_App_Action_Controller_PostProcess
extends Stub_Mephex_App_Action_Controller
{
	protected function processPostAction()
	{
		parent::processPostAction();
		throw new Stub_Mephex_App_Action_Exception_PostProcessTestException();
	}
}