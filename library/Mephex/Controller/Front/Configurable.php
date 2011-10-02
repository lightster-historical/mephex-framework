<?php



/**
 * Configurable controller for determining and running the 
 * action in the action controller.
 * 
 * @author mlight
 */
class Mephex_Controller_Front_Configurable
extends Mephex_Controller_Front_Base
{
	/**
	 * The configuration option set to use.
	 *
	 * @var Mephex_Config_OptionSet
	 */
	protected $_config;

	/**
	 * The config group that the system configuration options are located.
	 *
	 * @var string
	 */
	protected $_config_sys_group;



	public function __construct(
		Mephex_Config_OptionSet $config, $config_sys_group = 'mephex')
	{
		$this->_config				= $config;
		$this->_config_sys_group	= $config_sys_group;
	}



	/**
	 * Getter for config.
	 *
	 * @return Mephex_Config_OptionSet
	 */
	public function getConfig()
	{
		return $this->_config;
	}
	
	

	/**
	 * The router to use for determining the action controller and action
	 * name to run.
	 *
	 * @return Mephex_Controller_Router
	 * @see Mephex_Controller_Front_Base#generateRouter
	 */	
	protected function generateDefaultRouter()
	{
		$class_name	= $this->getSystemClassFromConfig(
			'router.class_name',
			'Mephex_Controller_Router'
		);
		return new $class_name($this);
	}



	/**
	 * Retrieves an option from the system config group.
	 *
	 * @param string $option - the name of the system option to retrieve
	 * @return mixed
	 */
	public function getSystemConfigOption($option)
	{
		return $this->getConfig()->get(
			$this->_config_sys_group,
			$option
		);
	}



	/**
	 * Retrieves and checks a system class name from a system config option.
	 *
	 * @param string $option - the system option name that the class name
	 *		should be located in
	 * @param string $expected_class - the class/interface the retrieved
	 *		class name is expected to extend/implement
	 * @return string
	 */
	public function getSystemClassFromConfig($option, $expected_class)
	{
		$expected	= new Mephex_Reflection_Class(
			$expected_class
		);
		return $expected->checkClassInheritance(
			$this->getSystemConfigOption($option)
		);
	}
}