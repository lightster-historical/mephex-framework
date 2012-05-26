<?php



class Stub_Mephex_App_Bootstrap_Base
extends Mephex_App_Bootstrap_Base
{
	public function setUpAutoLoader(Mephex_App_Class_AutoLoader $auto_loader)
		{return parent::setUpAutoLoader($auto_loader);}
	public function addDefaultClassLoaders(Mephex_App_Class_AutoLoader $auto_loader)
		{return parent::addDefaultClassLoaders($auto_loader);}
	public function getFrontController(Mephex_App_Resource_List $resource_list)
		{return parent::getFrontController($resource_list);}
}