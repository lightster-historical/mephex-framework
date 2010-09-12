<?php



class Mephex_Model_Accessor_ReaderTest
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
		$this->_stream		= new Stub_Mephex_Model_Stream_Reader();
		$this->_mapper		= new Stub_Mephex_Model_Mapper($this->_group);
		
		$this->_accessor		= new Stub_Mephex_Model_Accessor_Reader
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
	
	
	
	public function testReadUncachedObject()
	{
		$entity	= $this->_accessor->read(new Mephex_Model_Criteria_Array($criteria = array('Id' => 5)));
		$this->assertTrue($entity instanceof Mephex_Model_Entity);
		$this->assertEquals(5, $entity->getId());
	}
	
	
	
	public function testReadingCachedObjectReturnsCachedInstance()
	{
		$entity1	= $this->_accessor->read(new Mephex_Model_Criteria_Array($criteria = array('Id' => 6)));
		$this->assertTrue($entity1 instanceof Mephex_Model_Entity);
		$this->assertEquals(6, $entity1->getId());
		
		$entity2	= $this->_accessor->read(new Mephex_Model_Criteria_Array($criteria = array('Id' => 6)));
		$this->assertTrue($entity1 === $entity2);
	}
	
	
	
	public function testReadingCanReturnTwoDifferentObjects()
	{
		$entity1	= $this->_accessor->read(new Mephex_Model_Criteria_Array($criteria = array('Id' => 7)));
		$this->assertTrue($entity1 instanceof Mephex_Model_Entity);
		$this->assertEquals(7, $entity1->getId());
		
		$entity2	= $this->_accessor->read(new Mephex_Model_Criteria_Array($criteria = array('Id' => 8)));
		$this->assertTrue($entity2 instanceof Mephex_Model_Entity);
		$this->assertEquals(8, $entity2->getId());
		$this->assertFalse($entity1 === $entity2);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Criteria_Exception_UnknownKey
	 */
	public function testReadingWithAnInvalidCriteriaThrowsAnException()
	{
		$this->_accessor->read(new Mephex_Model_Criteria_Array($criteria = array('Unknown' => 7)));
	}
}  