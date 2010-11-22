<?php



class Stub_Mephex_Config_OptionSet
extends Mephex_Config_OptionSet
{
	public function canonicalizeKeys(&$group, &$option)
		{return parent::canonicalizeKeys($group, $option);}
	public function isOptionPreviouslyNotFound($group, $option)
		{return parent::isOptionPreviouslyNotFound($group, $option);}
	public function loadGroupOptions($group, $option)
		{return parent::loadGroupOptions($group, $option);}
	public function loadGenericOptions($group, $option)
		{return parent::loadGenericOptions($group, $option);}
	public function loadOptions(array $loaders, $group, $option)
		{return parent::loadOptions($loaders, $group, $option);}
	public function throwNotFoundException($group, $option)
		{return parent::throwNotFoundException($group, $option);}
}