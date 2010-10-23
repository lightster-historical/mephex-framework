<?php



class Stub_Mephex_Model_Criteria
extends Mephex_Model_Criteria
{
	// implement abstract methods
	public function hasCriteriaFields(array $field_names) 
	{
		foreach($field_names as $field_name)
		{
			if(!in_array($field_name, array('a', 'b', 'c')))
			{
				return false;
			}
		}
		
		return true;
	}
	
	
	
	public function getCriteriaValue($field_name) 
	{
		switch($field_name)
		{
			case 'a':	return 1;
			case 'b':	return 2;
			case 'c':	return 3;
		}
	}
}