<?php



/**
 * Loader used for lazy-loading configuration options from
 * an INI file..
 * 
 * @author mlight
 */
class Mephex_Config_Loader_Ini
extends Mephex_Config_Loader
{
	/**
	 * The path to the INI file.
	 * 
	 * @var string
	 */
	protected $_file_name	= null;
	
	
	
	/**
	 * @param string $file_name - the path to the INI file
	 */
	public function __construct($file_name)
	{
		$this->_file_name	= $file_name;
	}
	
	
	
	/**
	 * Loads the given group/option from an INI file into the option set.
	 * 
	 * @param Mephex_Config_OptionSet $option_set
	 * @param string $group
	 * @param string $option
	 * @return bool - whether or not the option was loaded
	 */
	public function loadOption(Mephex_Config_OptionSet $option_set, $req_group, $req_option)
	{
		// check to see if the path exists
		if(!file_exists($this->_file_name))
		{
			throw new Mephex_Exception("INI file not found: '{$this->_file_name}'");
		}
		// check to see if the path is a file and is readable
		else if(!is_file($this->_file_name) || !is_readable($this->_file_name))
		{
			throw new Mephex_Exception("INI file is inaccessible: '{$this->_file_name}'");
		}
		
		// load and parse the INI file
		$groups	= @parse_ini_file($this->_file_name, true);
		
		// check to see if the INI file was successfully parsed
		if($groups === false)
		{
			throw new Mephex_Exception("Error processing INI file: '{$this->_file_name}'");
		}
		
		foreach($groups as $group => $options)
		{
			// if the option was within a section,
			// use the section name as the group name
			if(is_array($options))
			{
				foreach($options as $option => $value)
				{
					$option_set->set($group, $option, $value);
				}
			}
			// if the option was outside a section, place it in
			// the 'default' group
			else if(is_scalar($options))
			{
				$option_set->set('default', $group, $options);
			}
		}
	}
}