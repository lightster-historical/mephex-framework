<?php



/**
 * Holds widely-used application objects (e.g. arguments, config options,
 * database connections)
 * 
 * @author mlight
 */
class Mephex_App_Registry
{
	/**
	 * The arguments passed into the application.
	 * 
	 * @var Mephex_App_Arguments
	 */
	private $_arguments;



	/**
	 * @param Mephex_App_Arguments $arguments - the arguments passed into the 
	 *		application
	 */
	public function __construct(Mephex_App_Arguments $arguments)
	{
		$this->_arguments	= $arguments;
	}



	/**
	 * Getter for arguments.
	 *
	 * @return Mephex_App_Arguments
	 */
	public function getArguments()
	{
		return $this->_arguments;
	}
}