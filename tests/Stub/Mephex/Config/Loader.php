<?php



class Stub_Mephex_Config_Loader
extends Mephex_Config_Loader
{
	public function loadOption(Mephex_Config_OptionSet $option_set, $group, $option)
	{
		if($group === 'database' || $group === 'environment')
		{
			$option_set->set('database', 'main_conn.host', 'localhost');
			$option_set->set('database', 'main_conn.database', 'some_db');
			$option_set->set('database', 'test_conn.host', 'test_host');
			$option_set->set('database', 'test_conn.database', 'test_db');
			
			$option_set->set('environment', 'environment', 'testing');
			$option_set->set('environment', 'logging', 'true');
		}
		else if($group === 'dev_tools')
		{
			$option_set->set('dev_tools', 'summary_stats', 'true');
			$option_set->set('dev_tools', 'profiling', 'true');
		}
		else if($group === 'collision')
		{
			$option_set->set('collision', 'source', 'main');
			$option_set->set('collision', 'other', 'uncollide');
		}
		
		return $option_set->hasOption($group, $option);
	}
}