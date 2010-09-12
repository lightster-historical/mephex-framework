<?php



/**
 * A cache to keep track of entity objects.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Cache
{
	/**
	 * The inner cache.
	 * 
	 * @var Mephex_Cache_Object
	 */
	private $_cache;
	
	
	
	public function __construct()
	{
		$this->_cache	= new Mephex_Cache_Object();
	}
	
	
	
	/**
	 * Remembers the given entity.
	 * 
	 * @param Mephex_Model_Entity $entity
	 * @return void
	 */
	public abstract function remember(Mephex_Model_Entity $entity);
	
	
	
	/**
	 * Forgets the given entity.
	 * 
	 * @param Mephex_Model_Entity $entity
	 */
	public function forget(Mephex_Model_Entity $entity)
	{
		return $this->_cache->removeObject($entity);
	}
	
	
	
	/**
	 * Getter for cache.
	 * 
	 * @return Mephex_Model_Cache
	 */
	protected function getCache()
	{
		return $this->_cache;
	}
	
	

	/**
	 * Determines if an entity has been remembered that meets
	 * the given criteria.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 * @return bool
	 */
	public function has(Mephex_Model_Criteria $criteria)
	{
		return $this->getCache()
			->has($this->_generateKeyFromCriteria($criteria));
	}
	
	
	
	/**
	 * Retrieves the entity that meets the given criteria.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 * @return Mephex_Model_Entity
	 */
	public function find(Mephex_Model_Criteria $criteria)
	{
		return $this->getCache()->find($this->_generateKeyFromCriteria($criteria));
	}
	
	
	
	/**
	 * Generates a string key using the given criteria.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 */
	protected abstract function generateKeyFromCriteria(Mephex_Model_Criteria $criteria);
	
	
	
	/**
	 * Wrapper of #generateKeyFromCriteria() that converts an invalid (empty)
	 * key to a Mephex_Model_Criteria_Exception_UnknownKey exception. 
	 * 
	 * @param Mephex_Model_Criteria $criteria - the criteria to generate the
	 * 		key from
	 */
	private function _generateKeyFromCriteria(Mephex_Model_Criteria $criteria)
	{
		$key	= $this->generateKeyFromCriteria($criteria);
		
		if(empty($key))
			$this->throwUnknownKeyException($criteria);	
		
		return $key;
	}
	
	
	
	/**
	 * Throws an invalid criteria exception.
	 * 
	 * @param Mephex_Model_Criteria $criteria - the invalid criteria used
	 */
	protected function throwUnknownKeyException(Mephex_Model_Criteria $criteria)
	{
		throw new Mephex_Model_Criteria_Exception_UnknownKey("The provided criteria do not represent a valid cache key.");	
	}
}