<?php



/**
 * Accessor for reading collections using a secondary reader.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Accessor_Reader_Collection
extends Mephex_Model_Accessor_Reader
{
	/**
	 * The reader that loads the entities that will
	 * be placed in the collection.
	 * 
	 * @var Mephex_Model_Accessor_Reader
	 */
	private $_secondary_reader;
	
	
	
	/**
	 * @param Mephex_Model_Accessor_Group $accessor_group
	 * @param Mephex_Model_Mapper $mapper
	 * @param Mephex_Model_Cache $cache
	 * @param Mephex_Model_Stream_Reader $stream
	 * @param Mephex_Model_Accessor_Reader $secondary_reader
	 */
	public function __construct(
		Mephex_Model_Accessor_Group $accessor_group,
		Mephex_Model_Mapper $mapper,
		Mephex_Model_Cache $cache,
		Mephex_Model_Stream_Reader $stream,
		Mephex_Model_Accessor_Reader $secondary_reader
	)
	{ 
		parent::__construct($accessor_group, $mapper, $cache, $stream);
		
		$this->_secondary_reader	= $secondary_reader;
	}
	
	
	
	/**
	 * Generates a collection object using the criteria and the
	 * raw data (in the iterator) provided by the stream reader.
	 * 
	 * @param Mephex_Model_Criteria $criteria
	 * @param Iterator $iterator - an iterator containing the raw data
	 * @see Mephex_Model_Accessor_Reader#generateEntity
	 */
	protected function generateEntity(Mephex_Model_Criteria $criteria, Iterator $iterator)
	{
		$secondary_reader	= $this->getSecondaryReader();
		
		$mapper		= $this->getMapper();
		$collection	= $mapper->getMappedEntity
		(
			$criteria
		);
		
		foreach($iterator as $data)
		{
			$secondary_criteria	= $this->generateSecondaryCriteria($data);
			$this->addEntity($collection, $secondary_reader->read($secondary_criteria));	
		}
		
		return $collection;
	}
	
	
	
	/**
	 * Getter for secondary reader.
	 * 
	 * @return Mephex_Model_Accessor_Reader
	 */
	protected function getSecondaryReader()
	{
		return $this->_secondary_reader;
	}
	
	
	
	/**
	 * Takes a raw record from the stream reader and generates
	 * a secondary criteria.
	 * 
	 * @param $data - raw record from the stream reader
	 * @return Mephex_Model_Criteria_StreamReader
	 */
	protected abstract function generateSecondaryCriteria($data);
	
	
	
	/**
	 * Adds the given entity to the given collection.
	 * 
	 * @param Mephex_Model_Entity_Collection $collection
	 * @param Mephex_Model_Entity $entity
	 */
	protected abstract function addEntity(Mephex_Model_Entity_Collection $collection, Mephex_Model_Entity $entity);
}