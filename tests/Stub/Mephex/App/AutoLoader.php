<?php



class Stub_Mephex_App_AutoLoader
extends Mephex_App_AutoLoader
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