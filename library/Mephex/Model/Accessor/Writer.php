<?php



/**
 * Accessor for writing entities to storage locations.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Accessor_Writer
extends Mephex_Model_Accessor
{
	/**
	 * The stream that provides write access to the raw data.
	 * 
	 * @var Mephex_Model_Accessor_Writer
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
		Mephex_Model_Stream_Writer $stream
	) 
	{
		parent::__construct($accessor_group, $mapper);

		$this->_cache	= $cache;
		$this->_stream	= $stream;
	}
	
	
	
	/**
	 * Getter for stream.
	 * 
	 * @return Mephex_Model_Stream_Writer
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
	 * Writes the entity.
	 * 
	 * @param Mephex_Model_Entity $entity
	 */
	public function write(Mephex_Model_Entity $entity)
	{
		$mapper	= $this->getMapper();
		$cache	= $this->getCache();
		$stream	= $this->getStream();
		
		$stream->write($mapper->getMappedData($entity));
		
		$this->updateCachedEntity($cache, $entity);
		
		return $entity;
	}
	
	
	
	/**
	 * Updates the keys of the given object within the cache.
	 * 
	 * @param Mephex_Model_Cache $cache
	 * @param Mephex_Model_Entity $entity
	 */
	protected function updateCachedEntity(Mephex_Model_Cache $cache, Mephex_Model_Entity $entity)
	{
		$cache->forget($entity);
		$cache->remember($entity);
	}
	
	
	
	/**
	 * Generates raw data from an entity so that it 
	 * can be passed to a stream writer.
	 * 
	 * @param Mephex_Model_Entity $entity
	 */
	protected abstract function generateData(
		Mephex_Model_Entity $entity 
	);
}