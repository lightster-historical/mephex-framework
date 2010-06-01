<?php



class Mephex_Model_Entity_ReferenceTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_stream;
	protected $_mapper;
	protected $_accessor;
	
	protected $_reference;
	
	protected $_criteria;
	
	
	
	public function setUp()
	{
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
	
	
	
	public function testRetrievedReaderIsTheSameObjectPassedToTheConstructor()
	{
		$this->assertTrue($this->_reader === $this->_reference->getReader());
	}
	
	
	
	public function testRetrievedCriteriaIsEqualToTheCriteriaPassedToTheConstructor()
	{
		$this->assertEquals($this->_criteria, $this->_reference->getCriteria());
	}
	
	
	
	public function testEntityCanBeLazyLoadedFromReference()
	{
		$entity	= $this->_reference->getEntity();
		
		$this->assertTrue($entity instanceof Mephex_Model_Entity);
		$this->assertEquals(6, $entity->getId());
	}
}