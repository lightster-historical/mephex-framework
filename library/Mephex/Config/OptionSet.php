<?php



/**
 * A data structure for organizing and lazy-loading
 * configuration options 
 * 
 * @author mlight
 */
class Mephex_Config_OptionSet
{
	/**
	 * Multi-dimensional associative array of options.
	 * 
	 * options[group_name][option_name]	= value
	 * 
	 * @var array
	 */
	protected $_options			= array();
	
	/**
	 * Multi-dimensional associative array of options that have
	 * previously been requested but were not found.
	 * 
	 * @var array
	 */
	protected $_not_found		= array();
	
	
	/**
	 * Loaders used for lazy-loading options for a given group.
	 * 
	 * group_loaders[group_name][] = loader
	 * 
	 * @var multi-dimensional array of Mephex_Config_Loader objects
	 */
	protected $_group_loaders	= array();
	
	/**
	 * Fallback loaders used after attempting to find the option in
	 * the available group loaders.
	 * 
	 * @var array of Mephex_Config_Loader objects
	 */
	protected $_loaders			= array();
	
	
	
	public function __construct()
	{
	}
	
	
	
	/**
	 * Retrieves the requested option from the given group.
	 * 
	 * @param string $group - the group the option is located in
	 * @param string $option - the name of the option
	 * @param mixed $default - the default value to use if
	 * 		the option is not found
	 * @param bool $required - whether or not an exception
	 * 		should be thrown if the option is not found
	 * @return mixed
	 */
	public function get($group, $option, $default = null, $required = null)
	{
		// check the cache to see if the option is already loaded
		$found	= $this->hasOption($group, $option) ? true : null;
		
		// check the "not-found cache" to see if the option was previously unsuccessfully loaded
		if($found === null)
		{	
			$found	= $this->hasOption($group, $option) ? false : null;
		}
		
		// attempt to load the option from the group loader
		if($found === null)
		{
			$found	= $this->loadGroupOptions($group, $option) ? true : null;
		}
		
		// attempt to load the option from a generic loader
		if($found === null)
		{
			$found	= $this->loadGenericOptions($group, $option) ? true : null;
		}
		
		// if the option was found, return the value
		if($found)
		{
			return $this->_options[$group][$option];
		}
		
		// apparently the option does not exist
		$this->_not_found[$group][$option]	= true;
		
		// if the option is required, throw an exception
		if($required === true || ($required === null && $default === null))
			$this->throwNotFoundException($group, $option);
		
		return $default;
	}
	
	
	
	/**
	 * Sets the value of the given option within the group.
	 * 
	 * @param string $group - the group the option is located in
	 * @param string $option - the name of the option
	 * @param mixed $value - the value to use for the option
	 * @param bool $override - whether or not to override the current value,
	 * 		if there is one
	 * @return bool - whether or not the option value was set
	 */
	public function set($group, $option, $value, $override = false)
	{		
		$store	= !$this->hasOption($group, $option) || $override;
		if($store)
		{
			$this->_options[$group][$option]	= $value;
		}
		
		return $store;
	}
	
	
	
	/**
	 * Determines if the given option is already loaded within
	 * the option set.
	 * 
	 * @param string $group
	 * @param string $option
	 * @return bool
	 */
	public function hasOption($group, $option)
	{
		return (isset($this->_options[$group][$option])
			|| (array_key_exists($group, $this->_options)
				&& array_key_exists($option, $this->_options[$group])));
	}
	
	
	
	/**
	 * Determines if the given option was previously requested
	 * but not found.
	 * 
	 * @param string $group
	 * @param string $option
	 * @return bool
	 */
	protected function isOptionPreviouslyNotFound($group, $option)
	{
		return isset($this->_not_found[$group][$option]);
	}

	
	
	/**
	 * Attempts to load the given option from the specified group
	 * using group loaders.
	 * 
	 * @param string $group
	 * @param string $option
	 * @return bool - whether or not the option was loaded
	 */
	protected function loadGroupOptions($group, $option)
	{
		return (isset($this->_group_loaders[$group])
			&& $this->loadOptions($this->_group_loaders[$group], $group, $option));
	}

	
	
	/**
	 * Attempts to load the given option from the specified group
	 * using generic loaders.
	 * 
	 * @param string $group
	 * @param string $option
	 * @return bool - whether or not the option was loaded
	 */
	protected function loadGenericOptions($group, $option)
	{
		return $this->loadOptions($this->_loaders, $group, $option);
	}
	
	
	
	/**
	 * Attempts to load the given option from the specified group
	 * using the provided loaders.
	 * 
	 * @param array $loaders - the loaders to search in when trying
	 * 		to load the option
	 * @param string $group
	 * @param string $option
	 * @return bool - whether or not the option was loaded
	 */
	protected function loadOptions(array $loaders, $group, $option)
	{
		foreach($loaders as $loader)
		{
			$loader->loadOption($this, $group, $option);
			
			if($this->hasOption($group, $option))
			{
				return true;
			}
		}
		
		return false;
	}
	
	
	
	/**
	 * Throws a 'not found' exception for the given group/option 
	 * 
	 * @param string $group
	 * @param string $option
	 * @throws Mephex_Exception
	 */
	protected function throwNotFoundException($group, $option)
	{
		throw new Mephex_Config_OptionSet_Exception_UnknownKey($this, $group, $option);
	}
	
	
	
	/**
	 * Adds a loader to the end of the option set's loader list.
	 * 
	 * @param Mephex_Config_Loader $loader
	 * @param string $group - the group that the loader
	 * 		should be used for (null = generic loader) 
	 * @return void
	 */
	public function addLoader(Mephex_Config_Loader $loader, $group = null)
	{
		if($group === null)
		{
			$this->_loaders[]	= $loader;
		}
		else
		{
			$this->_group_loaders[$group][]	= $loader;
		}
	}



	/**
	 * Adds a loader to the beginning of the option set's loader list.
	 * 
	 * @param Mephex_Config_Loader $loader
	 * @param string $group - the group that the loader
	 * 		should be used for (null = generic loader) 
	 * @return void
	 */
	public function stackLoader(Mephex_Config_Loader $loader, $group = null)
	{
		if($group === null)
		{
			array_unshift($this->_loaders, $loader);
		}
		else
		{
			array_unshift($this->_group_loaders[$group], $loader);
		}
	}
}