<?php



class Stub_Mephex_Config_GroupLoader
extends Mephex_Config_Loader
{
	public function loadOption(Mephex_Config_OptionSet $option_set, $group, $option)
	{
		if($group === 'in_db')
		{
			$option_set->set('in_db', 'option_a', 1);
			$option_set->set('in_db', 'option_b', 'x');
			$option_set->set('in_db', 'hmph', 'boom!');
		}
		else if($group === 'secondary_group')
		{
			$option_set->set('secondary_group', 'last_minute_loaded', 'yep');
		}
		else if($group === 'collision')
		{
			$option_set->set('collision', 'source', 'group');
		}
		
		return $option_set->hasOption($group, $option);
	}
}