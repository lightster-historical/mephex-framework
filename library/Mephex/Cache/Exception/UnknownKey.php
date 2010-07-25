<?php



/**
 * An exception thrown when a key has not been registered with a cache.
 * 
 * @author mlight
 */
class Mephex_Cache_Exception_UnknownKey
extends Mephex_Exception
{
	/**
	 * The cache object the key already existed in.
	 * 
	 * @var Mephex_Cache
	 */
	protected $_cache;
	
	/**
	 * They key we were looking for.
	 * 
	 * @var string
	 */
	protected $_key;
	
	
	
	/**
	 * @param $cache - the cache object the key could not be found in
	 * @param $key - the key we were looking for
	 */
	public function __construct($cache, $key)
	{
		parent::__construct("Unknown cache key: '{$key}'");
		
		$this->_cache	= $cache;
		$this->_key		= $key;
	}
	
	
	
	/**
	 * Getter for cache.
	 * 
	 * @return object
	 */
	public function getCache()
	{
		return $this->_cache;
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