<?php



class Stub_Mephex_Model_Accessor_Group
extends Mephex_Model_Accessor_Group
{
	// implementing an abstract method
	protected function init() {}
	
	
	
	// making protected methods public
	public function registerCache($class_name, Mephex_Model_Cache $cache)
		{return parent::registerCache($class_name, $cache);}
	public function registerAccessor($accessor_name, Mephex_Model_Accessor $accessor)
		{return parent::registerAccessor($accessor_name, $accessor);}
}