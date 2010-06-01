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
	public abstract function forget(Mephex_Model_Entity $entity);
	
	
	
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
			->has($this->generateKeyFromCriteria($criteria));
	}
	
	
	
	/**
	 * Retrieves the entity that meets the given criteria.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 * @return Mephex_Model_Entity
	 */
	public function find(Mephex_Model_Criteria $criteria)
	{
		return $this->getCache()
			->find($this->generateKeyFromCriteria($criteria));
	}
	
	
	
	/**
	 * Generates a string key using the given criteria.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 */
	protected abstract function generateKeyFromCriteria(Mephex_Model_Criteria $criteria);
}