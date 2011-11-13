<?php



class Stub_Mephex_Db_ConnectionManager_Configurable
extends Mephex_Db_ConnectionManager_Configurable
{
	public function getConnectionNickname
	(
		Mephex_Config_OptionSet $config,
		$group,
		$option
	)
	{
		return parent::getConnectionNickname($config, $group, $option);
	}

	public function generateConnection($name)
		{return parent::generateConnection($name);}
}