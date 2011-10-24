<?php



require_once 'Mephex/App/Bootstrap/Configurable.php';



/**
 * Class for bootstrapping an HTTP application using a configurable
 * OptionSet.
 * 
 * @author mlight
 */
class Mephex_App_Bootstrap_Http
extends Mephex_App_Bootstrap_Configurable
{
	/**
	 * @param Mephex_Config_OptionSet $config - the option set to use with app
	 */
	public function __construct(Mephex_Config_OptionSet $config)
	{
		parent::__construct($config);
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
		$http_args	= new Mephex_App_Arguments_Http(
			new Mephex_App_Arguments_HttpConnection($_SERVER),
			new Mephex_App_Arguments($_POST),
			new Mephex_App_Arguments($_GET),
			$arguments->getAll()
		);
		return parent::generateFrontController($http_args);
	}
}