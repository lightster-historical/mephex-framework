<?php



/**
 * Manages application arguments (e.g. command-line arguments, post/get/request
 * arguments)
 * 
 * @author mlight
 */
class Mephex_App_Arguments
{
	/**
	 * Array of arguments.
	 * 
	 * @var array
	 */
	protected $_args;
	
	
	
	/**
	 * @param array $args - a list of argument values to start off with
	 */
	public function __construct(array $args = null)
	{
		$this->_args	= ($args ? $args : array());
	}
	
	
	
	/**
	 * Checks to see if the specified argument has been set.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->_args);
	}
	
	
	
	/**
	 * Retrieves the argument by the specified name, or the specified default
	 * value if the argument has not yet been set.
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		return 
			($this->has($key)) ? $this->_args[$key]
				: $default
		;
	}
	
	
	
	/**
	 * Sets an argument using the specified name and value.
	 * 
	 * @param string $key
	 * @param mixed $val
	 * @return void
	 */
	public function set($key, $val)
	{
		$this->_args[$key]	= $val;
	}
	
	
	
	/**
	 * Sets several arguments using the specified array of arguments.
	 * 
	 * @param array $args
	 * @return void
	 */
	public function setAll(array $args)
	{
		$this->_args	= $args + $this->_args;
	}
	
	
	/**
	 * Clear the argument specified by the given name
	 * 
	 * @param string $key
	 * @return void
	 */
	public function clear($key)
	{
		unset($this->_args[$key]);
	}
	
	
	/**
	 * Clears all of the arguments.
	 * 
	 * @return $this
	 */
	public function clearAll()
	{
		$this->_args	= array();
		
		return $this;
	}
}