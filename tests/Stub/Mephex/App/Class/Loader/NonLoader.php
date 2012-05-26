<?php



class Stub_Mephex_App_Class_Loader_NonLoader
extends Mephex_App_Class_Loader
{
	public function loadClass($class_name) 
	{
		if(class_exists($class_name, false))
		{
			throw new Exception("Class '{$class_name}' is already loaded.");
		}
	}
}