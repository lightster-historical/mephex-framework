<?php



class Stub_Mephex_Controller_Action_PostProcess
extends Stub_Mephex_Controller_Action_Base
{
	protected function processPostAction()
	{
		parent::processPostAction();
		throw new Stub_Mephex_Controller_Action_Exception_PostProcessTestException();
	}
}