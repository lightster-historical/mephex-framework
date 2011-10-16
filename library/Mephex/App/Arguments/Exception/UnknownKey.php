<?php



/**
 * An exception thrown when a key is not found in the arguments list.
 * 
 * @author mlight
 */
class Mephex_App_Arguments_Exception_UnknownKey
extends Mephex_Exception
{
	/**
	 * The arguments object the key was not found in.
	 * 
	 * @var Mephex_App_Arguments
	 */
	protected $_arguments;
	
	/**
	 * They key we were looking for.
	 * 
	 * @var string
	 */
	protected $_key;
	
	
	
	/**
	 * @param Mephex_App_Arguments $cache - the arguments object the key could
	 *		not be found in
	 * @param $key - the key we were looking for
	 */
	public function __construct(Mephex_App_Arguments $arguments, $key)
	{
		parent::__construct("Unknown argument: '{$key}'");
		
		$this->_arguments	= $arguments;
		$this->_key			= $key;
	}
	
	
	
	/**
	 * Getter for arguments.
	 * 
	 * @return object
	 */
	public function getArguments()
	{
		return $this->_arguments;
	}
	
	
	
	/**
	 * Getter for key.
	 * 
	 * @return string
	 */
	public function getKey()
	{
		return $this->_key;
	}
}