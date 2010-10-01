<?php



class Stub_Mephex_App_AutoLoader
extends Mephex_App_AutoLoader
{
	public function clearInstance()
	{
		self::$_instance	= null;
	}

	
	
	public function restoreInstance($instance)
	{
		self::$_instance	= $instance;
	}
}