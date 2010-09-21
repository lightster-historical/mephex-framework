<?php



/**
 * Abstract loader used for lazy-loading configuration options.
 * 
 * @author mlight
 */
abstract class Mephex_Config_Loader
{
	/**
	 * Loads the given group/option into the option set.
	 * 
	 * @param Mephex_Config_OptionSet $option_set
	 * @param string $group
	 * @param string $option
	 * @return bool - whether or not the option was loaded
	 */
	public abstract function loadOption(Mephex_Config_OptionSet $option_set, $group, $option);
}