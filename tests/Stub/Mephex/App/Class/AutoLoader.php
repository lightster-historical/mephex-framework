<?php



class Stub_Mephex_App_Class_AutoLoader
extends Mephex_App_Class_AutoLoader
{
	public static function clearInstance()
	{
		self::$_instance	= null;
	}

	
	
	public static function restoreInstance($instance)
	{
		self::$_instance	= $instance;
	}
}