<?php



require_once 'Mephex/App/Bootstrap/Base.php';



/**
 * Class for bootstrapping an application using a configurable
 * OptionSet.
 * 
 * @author mlight
 */
class Mephex_App_Bootstrap_Configurable
extends Mephex_App_Bootstrap_Base
{
	/**
	 * The option set to use with the application.
	 *
	 * @var Mphex_Config_OptionSet
	 */
	private $_config;



	/**
	 * @param Mephex_Config_OptionSet $config - the option set to use with app
	 */
	public function __construct(Mephex_Config_OptionSet $config)
	{
		parent::__construct();

		$this->_config	= $config;
	}



	/**
	 * Getter for config.
	 *
	 * @return Mephex_Config_OptionSet
	 */
	protected function getConfig()
	{
		return $this->_config;
	}



	/**
	 * Generates the front controller to be used by the application.
	 *
	 * @param Mephex_App_Arguments $arguments - the arguments to pass to the 
	 *		front controller
	 * @return Mephex_Controller_Front_Configurable
	 * @see Mephex_App_Bootstrap_Base#generateFrontController
	 */
	protected function generateFrontController(Mephex_App_Arguments $arguments)
	{
		return new Mephex_Controller_Front_Configurable(
			$arguments,
			$this->getConfig(), 
			$this->getConfig()->get('default', 'system_group', 'mephex')
		);
	}
}