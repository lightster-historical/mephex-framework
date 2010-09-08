<?php



class Stub_Mephex_Model_Stream_Writer
extends Mephex_Model_Stream_Writer
{
	public function write($data)
	{
		$fields	= array_keys($data);
		
		if(array_key_exists('id', $fields)
			&& array_key_exists('name', $fields))
		{
			return true;	
		}
		
		return false;
	}
}