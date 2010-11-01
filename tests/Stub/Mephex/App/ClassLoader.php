<?php



class Stub_Mephex_App_ClassLoader
extends Mephex_App_ClassLoader
{
	public function includeExists($path)
		{return parent::includeExists($path);}
		
	public function loadClass($class_name) {}
}