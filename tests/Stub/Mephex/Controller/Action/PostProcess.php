<?php



class Stub_Mephex_Controller_Action_PostProcess
extends Stub_Mephex_Controller_Action
{
	protected function processPostAction()
	{
		parent::processPostAction();
		throw new Stub_Mephex_Controller_Exception_PostProcessTestException();
	}
}