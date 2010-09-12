<?php



/**
 * A cache to keep track of object instances. 
 * 
 * @author mlight
 */
class Mephex_Cache_Object
{
	/**
	 * The array of objects indexed by cache keys.
	 * 
	 * @var associative array of objects
	 */
	private $_objects;
	
	
	
	public function __construct()
	{
		$this->_objects	= array();
	}
	
	
	
	/**
	 * Remembers a object using a specific key.
	 * 
	 * @param string $key - the key to remember the object by
	 * @param $object - the object to remember
	 * @throws Mephex_Cache_Exception_DuplicateKey
	 */
	public function remember($key, $object)
	{
		if(array_key_exists($key, $this->_objects))
		{
			throw new Mephex_Cache_Exception_DuplicateKey($this, $key);
		}
		
		$this->_objects[$key]	= $object;
	}
	
	
	
	/**
	 * Forgets the object stored by the specified key
	 * 
	 * @param string $key - the key to forget
	 * @param bool $ignore - whether or not to ignore a missing key;
	 * 		if false (default), an exception is thrown
	 * @throws Mephex_Cache_Exception_UnknownKey
	 */
	public function forget($key, $ignore = false)
	{
		if(!array_key_exists($key, $this->_objects))
		{
			if($ignore)
			{
				return false;
			}
			
			throw new Mephex_Cache_Exception_UnknownKey($this, $key);
		}
		
		unset($this->_objects[$key]);
		
		return true;
	}
	
	
	
	/**
	 * Forgets all objects.
	 * 
	 * @return void
	 */
	public function forgetAll()
	{
		$this->_objects	= array();
	}
	
	
	
	/**
	 * Removes the given object from the cache, regardless of how many 
	 * keys it is associated with.
	 * 
	 * @param $object
	 * @return array
	 */
	public function & removeObject($object)
	{
		$keys	= array();
		while(false !== ($key = array_search($object, $this->_objects, true)))
		{
			$keys[]	= $key;
			unset($this->_objects[$key]);
		}
		
		return $keys;
	}
	
	

	/**
	 * Checks to see if a key has been remembered
	 *  
	 * @param string $key - the key to check for
	 * @return bool
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->_objects);
	}
	
	
	
	/**
	 * Retrieves the object remembered by the given key
	 * 
	 * @param string $key - the key to find
	 * @return object
	 * @throws Mephex_Cache_Exception_UnknownKey
	 */
	public function find($key)
	{
		if(!array_key_exists($key, $this->_objects))
		{
			throw new Mephex_Cache_Exception_UnknownKey($this, $key);
		}
		
		return $this->_objects[$key];
	}
}