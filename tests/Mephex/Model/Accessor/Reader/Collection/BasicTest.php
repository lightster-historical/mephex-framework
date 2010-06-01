<?php



class Mephex_Model_Accessor_Reader_Collection_BasicTest
extends Mephex_Test_TestCase
{
	protected $_cache;
	protected $_group;
	
	protected $_stream;
	protected $_mapper;
	protected $_reader;
	
	protected $_secondary_reader;
	
	
	
	public function setUp()
	{
		$this->_cache		= new Stub_Mephex_Model_Cache();
		$this->_group		= new Stub_Mephex_Model_Accessor_Group();
		
		$this->_secondary_mapper	= new Stub_Mephex_Model_Mapper($this->_group);
		
		$this->_stream		= new Stub_Mephex_Model_Stream_Reader();
		$this->_mapper		= new Stub_Mephex_Model_Mapper_Collection($this->_group);
		$this->_reader	
			= new Stub_Mephex_Model_Accessor_Reader_Collection_Basic
			(
				$this->_group,
				$this->_mapper,
				$this->_cache,
				$this->_stream,
				$this->_secondary_mapper,
				$this->_cache
			);
	} 
	
	
	
	public function testSecondaryReaderIsAReaderEntity()
	{
		$this->assertTrue(
			$this->_reader->getSecondaryReader() 
				instanceof Mephex_Model_Accessor_Reader_Entity
		);
	}
}  