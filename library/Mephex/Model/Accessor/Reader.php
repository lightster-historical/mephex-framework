<?php



/**
 * Accessor for reading and caching entities from storage
 * locations.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Accessor_Reader
extends Mephex_Model_Accessor
{
	/**
	 * The stream that provides access to the raw data.
	 * 
	 * @var Mephex_Model_Accessor_Reader
	 */
	private $_stream;
	
	/**
	 * The cache where loaded entities are remembered.
	 * 
	 * @var Mephex_Model_Cache
	 */
	private $_cache;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $accessor_group
	 * @param Mephex_Model_Mapper $mapper
	 * @param Mephex_Model_Cache $cache
	 * @param Mephex_Model_Stream_Reader $stream
	 */
	public function __construct(
		Mephex_Model_Accessor_Group $accessor_group,
		Mephex_Model_Mapper $mapper,
		Mephex_Model_Cache $cache,
		Mephex_Model_Stream_Reader $stream
	) 
	{
		parent::__construct($accessor_group, $mapper);

		$this->_cache	= $cache;
		$this->_stream	= $stream;
	}
	
	
	
	/**
	 * Getter for stream.
	 * 
	 * @return Mephex_Model_Stream_Reader
	 */
	protected function getStream()
	{
		return $this->_stream;
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
	 * Returns the entity that meets the given criteria.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 */
	public function read(Mephex_Model_Criteria $criteria)
	{
		$mapper	= $this->getMapper();
		$cache	= $this->getCache();
		
		try
		{
			$entity	= $this->getCachedEntity($cache, $criteria);
		}
		// re-throw this type of exception
		catch(Mephex_Model_Criteria_Exception_UnknownKey $ex)
		{
			throw $ex;
		}
		catch(Mephex_Cache_Exception_UnknownKey $ex)
		{
			$stream	= $this->getStream();
			$iterator	= $stream->read($criteria);
			
			$entity		= $this->generateEntity($criteria, $iterator);
			
			$cache->remember($entity);
		}
		
		return $entity;
	}
	
	
	
	/**
	 * Attempts to read the entity from the cache.
	 * 
	 * @param Mephex_Model_Cache $cache - the cache to read from
	 * @param Mephex_Model_Criteria $criteria
	 * @throws Mephex_Cache_Exception_UnknownKey
	 */
	protected function getCachedEntity(Mephex_Model_Cache $cache, Mephex_Model_Criteria $criteria)
	{
		return $cache->find($criteria);
	}
	
	
	
	/**
	 * Generates an entity object using the criteria and the
	 * raw data (in the iterator) provided by the stream reader.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 * @param Iterator $iterator - an iterator containing the raw data
	 */
	protected abstract function generateEntity(
		Mephex_Model_Criteria $criteria, 
		Iterator $iterator
	);
}