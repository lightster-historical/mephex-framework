<?php



/**
 * An exception thrown when a key has already been registered with a cache.
 * 
 * @author mlight
 */
class Mephex_Cache_Exception_DuplicateKey
extends Mephex_Exception
{
	/**
	 * The cache object the key already existed in.
	 * 
	 * @var Mephex_Cache
	 */
	protected $_cache;
	
	/**
	 * They key we were trying to use.
	 * 
	 * @var string
	 */
	protected $_key;
	
	
	
	/**
	 * @param $cache - the cache object the key already existed in
	 * @param $key - the key we were trying to use
	 */
	public function __construct($cache, $key)
	{
		parent::__construct("Duplicate cache key: '{$key}'");
		
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