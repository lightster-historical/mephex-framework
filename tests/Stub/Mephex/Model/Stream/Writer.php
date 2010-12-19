<?php



class Stub_Mephex_Model_Stream_Writer
extends Mephex_Model_Stream_Writer
{
	public function create($data)
	{
		if(array_key_exists('id', $data))
		{
			return $data['id'];	
		}
		
		return null;
	}
	
	
	
	public function update($data)
	{
		if(array_key_exists('id', $data))
		{
			return $data['id'];	
		}
		
		return null;
	}
}