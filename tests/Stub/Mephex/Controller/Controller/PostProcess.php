<?php



class Stub_Mephex_Controller_Controller_PostProcess
extends Stub_Mephex_Controller_Controller
{
	protected function processPostAction()
	{
		parent::processPostAction();
		throw new Stub_Mephex_Controller_Exception_PostProcessTestException();
	}
}