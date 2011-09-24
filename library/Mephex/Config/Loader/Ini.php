<?php



/**
 * Loader used for lazy-loading configuration options from
 * an INI file.
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
	 * The raw options from the parsed ini file.
	 *
	 * @var array
	 */
	protected $_options		= null;
	
	
	
	/**
	 * @param string $file_name - the path to the INI file
	 */
	public function __construct($file_name)
	{
		$this->_file_name	= $file_name;
	}



	/**
	 * Loads the options from the configuration file.
	 *
	 * @return void
	 */
	protected function readFile()
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
		$this->_options	= @parse_ini_file($this->_file_name, true);
		
		// check to see if the INI file was successfully parsed
		if($this->_options === false)
		{
			throw new Mephex_Exception("Error processing INI file: '{$this->_file_name}'");
		}
	}



	/**
	 * Lazy-loading getter for options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		if(null === $this->_options)
		{
			$this->readFile();
		}

		return $this->_options;
	}
	
	
	
	/**
	 * Loads the given group/option from an INI file into the option set.
	 * 
	 * @param Mephex_Config_OptionSet $option_set
	 * @param string $group
	 * @param string $option
	 * @return bool - whether or not the option was loaded
	 */
	public function loadOption(
		Mephex_Config_OptionSet $option_set, $req_group, $req_option
	)
	{
		$options	= $this->getOptions();

		$found	= false;
		if($req_group === 'default')
		{
			if(array_key_exists($req_option, $options)) 
			{
				$found	= true;
				$value	= $options[$req_option];
			}
		}
		else if(array_key_exists($req_group, $options)
			&& array_key_exists($req_option, $options[$req_group])
		)
		{
			$found	= true;
			$value	= $options[$req_group][$req_option];
		}

		if($found)
		{
			$option_set->set($req_group, $req_option, $value);
		}
	}
}