<?php



/**
 * Accessor group for accessing related entities.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Accessor_Group
{
	/**
	 * Object caches, indexed by base class names.
	 * 
	 * @var array of Mephex_Model_Cache objects
	 */
	private $_caches	= array();
	
	
	
	/**
	 * Accessors for reading, indexed by programmer-defined 
	 * accessor names.
	 * 
	 * @var array of Mephex_Model_Accessor_Reader objects
	 */
	private $_readers	= array();
	
	/**
	 * Accessors for writing, indexed by programmer-defined 
	 * accessor names.
	 * 
	 * @var array of Mephex_Model_Accessor_Writer objects
	 */
	private $_writers	= array();
	
	/**
	 * Accessors for erasing, indexed by programmer-defined 
	 * accessor names.
	 * 
	 * @var array of Mephex_Model_Accessor_Eraser objects
	 */
	private $_erasers	= array();
	
	
	
	public function __construct()
	{
		$this->init();
	}
	
	
	
	/**
	 * Initializes the accessor group, including all accessors
	 * and caches.
	 */
	protected abstract function init();
	
	

	/**
	 * Registers a cache.
	 * 
	 * @param string $class_name - the base class name of the 
	 * 		objects the cache is handling.
	 * @param Mephex_Model_Cache $cache - the object cache
	 */
	protected function registerCache($class_name, Mephex_Model_Cache $cache)
	{
		if(isset($this->_caches[$class_name]))
		{
			throw new Mephex_Model_Accessor_Exception_DuplicateEntityCache($this, $class_name);
		}
		
		$this->_caches[$class_name]	= $cache;
	}
	
	
	
	/**
	 * Retrieves the cache for the given base class name.
	 * 
	 * @param string $class_name
	 * @return Mephex_Model_Cache
	 */
	public function getCache($class_name)
	{
		if(!isset($this->_caches[$class_name]))
		{
			throw new Mephex_Model_Accessor_Exception_UnknownEntityCache($this, $class_name);
		}
		
		return $this->_caches[$class_name];
	}
	
	

	/**
	 * Registers an accessor.
	 * 
	 * @param string $accessor_name - the name to give the accessor
	 * @param Mephex_Model_Accessor $accessor - the accessor
	 * 		to register
	 */
	protected function registerAccessor($accessor_name, Mephex_Model_Accessor $accessor)
	{
		if($accessor instanceof Mephex_Model_Accessor_Reader)
		{
			$this->_readers[$accessor_name]	= $accessor;
		}
		else if($accessor instanceof Mephex_Model_Accessor_Writer)
		{
			$this->_writers[$accessor_name]	= $accessor;
		}
		else if($accessor instanceof Mephex_Model_Accessor_Eraser)
		{
			$this->_erasers[$accessor_name]	= $accessor;
		}
		else
		{
			throw new Mephex_Model_Accessor_Exception_InvalidAccessor($this, $accessor_name, $accessor);
		}
	}
	
	
	
	/**
	 * Retrieves the reader accessor by the given name.
	 * 
	 * @param string $accessor_name
	 * @return Mephex_Model_Accessor_Reader
	 */
	public function getReader($accessor_name)
	{
		if(!isset($this->_readers[$accessor_name]))
		{
			throw new Mephex_Model_Accessor_Exception_UnknownReader($this, $accessor_name);
		}
		
		return $this->_readers[$accessor_name];
	}
	
	
	
	/**
	 * Retrieves the writer accessor by the given name.
	 * 
	 * @param string $accessor_name
	 * @return Mephex_Model_Accessor_Writer
	 */
	public function getWriter($accessor_name)
	{
		if(!isset($this->_writers[$accessor_name]))
		{
			throw new Mephex_Model_Accessor_Exception_UnknownWriter($this, $accessor_name);
		}
		
		return $this->_writers[$accessor_name];
	}
	
	
	
	/**
	 * Retrieves the eraser accessor by the given name.
	 * 
	 * @param string $accessor_name
	 * @return Mephex_Model_Accessor_Eraser
	 */
	public function getEraser($accessor_name)
	{
		if(!isset($this->_erasers[$accessor_name]))
		{
			throw new Mephex_Model_Accessor_Exception_UnknownEraser($this, $accessor_name);
		}
		
		return $this->_erasers[$accessor_name];
	}
	
	
	
	/**
	 * Reads an object that meets the given criteria using the named
	 * reader. 
	 * 
	 * @param string $accessor_name
	 * @param Mephex_Model_Criteria $criteria
	 * @return Mephex_Model_Entity
	 */
	public function read($accessor_name, Mephex_Model_Criteria $criteria)
	{
		return $this->getReader($accessor_name)->read($criteria);
	}
	
	
	
	/**
	 * Writes the given object using the named writer.
	 * 
	 * @param string $accessor_name
	 * @param Mephex_Model_Entity $entity
	 * @return Mephex_Model_Entity
	 */
	public function write($accessor_name, Mephex_Model_Entity $entity)
	{
		return $this->getWriter($accessor_name)->write($entity);
	}
	
	
	
	/**
	 * Erases the given object using the named eraser.
	 * 
	 * @param string $accessor_name
	 * @param Mephex_Model_Entity $entity
	 * @return void
	 */
	public function erase($accessor_name, Mephex_Model_Entity $entity)
	{
		return $this->getEraser($accessor_name)->erase($entity);
	}
	
	
	
	/**
	 * Generates a reference using the given reader accessor name
	 * and the criteria.
	 * 
	 * @param string $accessor_name
	 * @return Mephex_Model_Accessor_Reader
	 */
	public function getReference($accessor_name, Mephex_Model_Criteria $criteria)
	{
		return new Mephex_Model_Entity_Reference(
			$this->getReader($accessor_name), $criteria
		); 
	} 
}