<?php



class Mephex_Model_Accessor_Reader_EntityTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_stream;
	protected $_mapper;
	
	protected $_reader;
	
	
	
	public function setUp()
	{
		$this->_group		= new Stub_Mephex_Model_Accessor_Group();
		$this->_cache		= new Stub_Mephex_Model_Cache();
		$this->_stream		= new Stub_Mephex_Model_Stream_Reader();
		$this->_mapper		= new Stub_Mephex_Model_Mapper($this->_group);

		$this->_reader		= new Stub_Mephex_Model_Accessor_Reader_Entity
		(
			$this->_group,
			$this->_mapper,
			$this->_cache,
			$this->_stream
		);		
	} 
	
	
	
	public function testGenerateEntityMapsFirstRecord()
	{
		$array	= new ArrayObject
		(
			array
			(
				array
				(
					'id'		=> 1,
					'parent'	=> null
				),
				array
				(
					'id'		=> 2,
					'parent'	=> null
				)
			)
		);
		
		$entity	= $this->_reader->generateEntity(new Mephex_Model_Criteria_Array(array()), $array->getIterator());
		$this->assertEquals(1, $entity->getId());
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Accessor_Exception_EmptyResultSet
	 */
	public function testGenerateEntityUsingEmptyIteratorThrowsAnException()
	{
		$array	= new ArrayObject();
		
		$this->_reader->generateEntity(new Mephex_Model_Criteria_Array(array()), $array->getIterator());
	}
}  