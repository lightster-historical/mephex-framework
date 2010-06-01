<?php



class Stub_Mephex_Model_Accessor
extends Mephex_Model_Accessor
{
	// making protected methods public
	public function getAccessorGroup()
		{return parent::getAccessorGroup();}
	public function getMapper()
		{return parent::getMapper();}
}