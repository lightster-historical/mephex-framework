<?php



class Mephex_Model_Accessor_Reader_CollectionTest
extends Mephex_Test_TestCase
{
	protected $_cache;
	protected $_group;
	
	protected $_stream;
	protected $_mapper;
	protected $_reader;
	
	protected $_secondary_stream;
	protected $_secondary_mapper;
	protected $_secondary_reader;
	
	
	
	public function setUp()
	{
		$this->_cache		= new Stub_Mephex_Model_Cache();
		$this->_group		= new Stub_Mephex_Model_Accessor_Group();
		
		$this->_secondary_stream	= new Mephex_Model_Stream_Reader_Passthru('Secondary_Entity');
		$this->_secondary_mapper	= new Stub_Mephex_Model_Mapper($this->_group);
		$this->_secondary_reader	= new Stub_Mephex_Model_Accessor_Reader
			(
				$this->_group,
				$this->_secondary_mapper,
				$this->_cache,
				$this->_secondary_stream
			);
		
		$this->_stream		= new Stub_Mephex_Model_Stream_Reader();
		$this->_mapper		= new Stub_Mephex_Model_Mapper_Collection($this->_group);
		$this->_reader	
			= new Stub_Mephex_Model_Accessor_Reader_Collection
			(
				$this->_group,
				$this->_mapper,
				$this->_cache,
				$this->_stream,
				$this->_secondary_reader
			);
	} 
	
	
	
	public function testSecondaryReaderIsTheSameObjectPassedToTheConstructor()
	{
		$this->assertTrue($this->_secondary_reader === $this->_reader->getSecondaryReader());
	}
	
	

	public function testGenerateEntityReturnsACollection()
	{
		$criteria	= new Mephex_Model_Criteria_Array(array('parentId' => 2));
		$array	= new ArrayObject
		(
			array
			(
				array
				(
					'id'		=> 3,
					'parent'	=> $criteria->getCriteriaValue('parentId')
				),
				array
				(
					'id'		=> 4,
					'parent'	=> $criteria->getCriteriaValue('parentId')
				)
			)
		);	
		$collection	= $this->_reader->generateEntity($criteria, $array->getIterator());
		
		$this->assertTrue($collection instanceof Mephex_Model_Entity_Collection);

		$this->assertEquals(3, $this->_reader->unit_test_entities[0]->getId());
		$this->assertEquals(4, $this->_reader->unit_test_entities[1]->getId());
	}
}  