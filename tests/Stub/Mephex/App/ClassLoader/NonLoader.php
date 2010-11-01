<?php



class Stub_Mephex_App_ClassLoader_NonLoader
extends Mephex_App_ClassLoader
{
	public function loadClass($class_name) 
	{
		if(class_exists($class_name, false))
		{
			throw new Exception("Class '{$class_name}' is already loaded.");
		}
	}
}