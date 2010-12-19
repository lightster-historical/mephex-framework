<?php



class Mephex_Model_Accessor_WriterTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_cache;
	protected $_stream;
	protected $_mapper;
	
	protected $_accessor;
	
	
	
	public function setUp()
	{
		$this->_group		= new Stub_Mephex_Model_Accessor_Group();
		$this->_cache		= new Stub_Mephex_Model_Cache();
		$this->_stream		= new Stub_Mephex_Model_Stream_Writer();
		$this->_mapper		= new Stub_Mephex_Model_Mapper($this->_group);
		
		$this->_accessor		= new Stub_Mephex_Model_Accessor_Writer
		(
			$this->_group,
			$this->_mapper,
			$this->_cache,
			$this->_stream
		);		
	} 
	
	
	
	public function testRetrievedStreamIsTheSameStreamPassedToTheConstructor()
	{
		$this->assertTrue($this->_accessor->getStream() === $this->_stream);
	}
	
	
	
	public function testRetrievedCacheIsTheSameCachePassedToTheConstructor()
	{
		$this->assertTrue($this->_accessor->getCache() === $this->_cache);
	}
	
	
	
	public function testWriteUncachedNewObject()
	{
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		
		$entity		= new Stub_Mephex_Model_Entity();
		$entity->setId(1);
		$entity->setName('test');
		$entity->markNew();
		$this->_accessor->write($entity);
		
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
	}
	
	
	
	public function testWriteUncachedExistingObject()
	{
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		
		$entity		= new Stub_Mephex_Model_Entity();
		$entity->setId(1);
		$entity->setName('test');
		$entity->markDirty();
		$this->_accessor->write($entity);
		
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
	}
	
	
	
	public function testWritingCachedNewObjectUpdatesCacheKey()
	{
		$entity		= new Stub_Mephex_Model_Entity();
		$entity->setId(1);
		$entity->setName('test');
		$entity->markNew();
		
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 2))));
		
		$this->_accessor->write($entity);
		
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 2))));
		
		$entity->setId(2);
		$this->_accessor->write($entity);
		
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 2))));
	}
	
	
	
	public function testWritingCachedExistingObjectUpdatesCacheKey()
	{
		$entity		= new Stub_Mephex_Model_Entity();
		$entity->setId(1);
		$entity->setName('test');
		$entity->markDirty();
		
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 2))));
		
		$this->_accessor->write($entity);
		
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 2))));
		
		$entity->setId(2);
		$this->_accessor->write($entity);
		
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 1))));
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array($criteria = array('Id' => 2))));
	}
	
	
	
	public function testTheEntityIsMarkedAsCleanImmediatelyAfterWriting()
	{
		$entity		= new Stub_Mephex_Model_Entity();
		$entity->setId(1);
		$entity->setName('test');
		$entity->markDirty();
		
		$this->assertFalse($entity->isMarkedClean());
		
		$this->_accessor->write($entity);
		
		$this->assertTrue($entity->isMarkedClean());
	}
}  