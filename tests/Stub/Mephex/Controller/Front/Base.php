<?php



class Stub_Mephex_Controller_Front_Base
extends Mephex_Controller_Front_Base
{
	// make protected methods public for unit testing purposes
	public function getRouter()
		{return parent::getRouter();}
	public function getActionController(Mephex_Controller_Router $router)
		{return parent::getActionController($router);}
	public function generateActionController($class_name)
		{return parent::generateActionController($class_name);}
}