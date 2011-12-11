<?php



/**
 * An exception thrown when a requested key is not found in the option set.
 * 
 * @author mlight
 */
class Mephex_Config_OptionSet_Exception_UnknownKey
extends Mephex_Exception
{
	/**
	 * The option set the key could  not be found in.
	 * 
	 * @var Mephex_Config_OptionSet
	 */
	protected $_option_set;
	
	/**
	 * The group we were looking for.
	 * 
	 * @var string
	 */
	protected $_group;
	
	/**
	 * The option we were looking for.
	 * 
	 * @var string
	 */
	protected $_option;
	
	
	
	/**
	 * @param Mephex_Config_OptionSet $option_set - the option set the group/option could not be found in
	 * @param string $group - the group we were looking for
	 * @param string $group - the option set we were looking for
	 */
	public function __construct(Mephex_Config_OptionSet $option_set, $group, $option)
	{
		parent::__construct("Config option '{$group}'.'{$option}' not found.");
		
		$this->_option_set	= $option_set;
		$this->_group		= $group;
		$this->_option		= $option;
	}
	
	
	
	/**
	 * Getter for config option set.
	 * 
	 * @return Mephex_Config_OptionSet
	 */
	public function getConfigOptionSet()
	{
		return $this->_option_set;
	}
	
	
	
	/**
	 * Getter for group.
	 * 
	 * @return string
	 */
	public function getGroup()
	{
		return $this->_group;
	}
	
	
	
	/**
	 * Getter for option.
	 * 
	 * @return string
	 */
	public function getOption()
	{
		return $this->_option;
	}
}