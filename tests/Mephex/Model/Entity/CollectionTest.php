<?php



class Mephex_Model_Entity_CollectionTest
extends Mephex_Test_TestCase
{
	protected $_collection;
	
	protected $_entity;
	
	protected $_group;
	protected $_stream;
	protected $_mapper;
	protected $_accessor;
	
	protected $_reference;
	
	protected $_criteria;
		
		
	
	public function setUp()
	{
		$this->_collection	= new Stub_Mephex_Model_Entity_Collection();
		
		$this->_entity		= new Stub_Mephex_Model_Entity();
		$this->_entity->setId(24);
		
		$this->_group		= new Stub_Mephex_Model_Accessor_Group();
		$this->_cache		= new Stub_Mephex_Model_Cache();
		$this->_stream		= new Stub_Mephex_Model_Stream_Reader();
		$this->_mapper		= new Stub_Mephex_Model_Mapper($this->_group);
		
		$this->_reader		= new Stub_Mephex_Model_Accessor_Reader
		(
			$this->_group,
			$this->_mapper,
			$this->_cache,
			$this->_stream
		);		
		
		$this->_criteria	= new Mephex_Model_Criteria_Array(array('Id' => 6));
		
		$this->_reference	= new Mephex_Model_Entity_Reference($this->_reader, $this->_criteria);
	}
	
	
	
	public function testCollectionEntityImplementsIterator()
	{
		$this->assertTrue($this->_collection instanceof Iterator);
	}
	
	
	
	public function testCollectionEntityImplementsCountable()
	{
		$this->assertTrue($this->_collection instanceof Countable);
	}
	
	
	
	public function testEntityCanBeAddedToCollection()
	{
		$this->assertEquals(0, count($this->_collection));
		$this->_collection->addChild($this->_entity);
		$this->assertEquals(1, count($this->_collection));
	}
	
	
	
	public function testReferenceCanBeAddedToCollection()
	{
		$this->assertEquals(0, count($this->_collection));
		$this->_collection->addChild($this->_reference);
		$this->assertEquals(1, count($this->_collection));
	}
	
	
	
	public function testCollectionIsNotValidIfEmpty()
	{
		$this->assertFalse($this->_collection->valid());
	}
	
	
	
	public function testCollectionWithEntitiesIsInitiallyValid()
	{
		$this->_collection->addChild($this->_entity);
		$this->assertTrue($this->_collection->valid());
	}
	
	
	
	public function testCanRewindCollection()
	{
		$this->_collection->addChild($this->_entity);
		
		foreach($this->_collection as $entity)
		{
		}
		
		$this->assertFalse($this->_collection->valid());
		
		$this->_collection->rewind();
		$this->assertTrue($this->_entity === $this->_collection->current());
	}
	
	
	
	public function testCurrentPointerCanBeMovedToNext()
	{
		$second	= new Stub_Mephex_Model_Entity();
		
		$this->_collection->addChild($this->_entity);
		$this->_collection->addChild($second);
		
		$this->assertTrue($this->_collection->current() === $this->_entity);
		$this->_collection->next();
		$this->assertTrue($this->_collection->current() === $second);
	}
	
	
	
	public function testEntityUniqueIdentifierIsIteratorKey()
	{
		$second	= new Stub_Mephex_Model_Entity();
		$second->setId(33);
		
		$this->_collection->addChild($this->_entity);
		$this->_collection->addChild($second);
		
		$this->assertEquals(24, $this->_collection->key());
		$this->_collection->next();
		$this->assertEquals(33, $this->_collection->key());
	}
	
	
	
	public function testEntityIteratedIsSameAddedToCollection()
	{
		$this->_collection->addChild($this->_entity);
		
		foreach($this->_collection as $entity)
		{
			$this->assertTrue($this->_entity === $entity);
		}
	}
	
	
	
	public function testReferenceIteratedIsLoadedAsEntity()
	{
		$this->_collection->addChild($this->_reference);
		
		foreach($this->_collection as $entity)
		{
			$this->assertTrue($entity instanceof Stub_Mephex_Model_Entity);
		}
	}
	
	
	
	public function testACombinationOfEntitiesAndReferencesCanBeIterated()
	{
		$this->_collection->addChild($this->_entity);
		$this->_collection->addChild($this->_reference);
		$this->_collection->addChild($this->_reference);
		$this->_collection->addChild($this->_entity);
	
		foreach($this->_collection as $entity)
		{
			$this->assertTrue
			(
				$entity instanceof Stub_Mephex_Model_Entity
				|| $entity instanceof Stub_Mephex_Model_Entity_Reference
			);
		}
	}
}