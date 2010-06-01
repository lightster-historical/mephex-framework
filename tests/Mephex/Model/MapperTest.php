<?php



class Mephex_Model_MapperTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_mapper;
	
	
	
	public function setUp()
	{
		$this->_group	= new Stub_Mephex_Model_Accessor_Group();
		$this->_mapper	= new Stub_Mephex_Model_Mapper($this->_group);
	}
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_mapper instanceof Mephex_Model_Mapper);
	}
	
	
	
	public function testRetrieveAccessorGroupIsTheSameObjectPassedToTheConstructor()
	{
		$this->assertTrue($this->_mapper->getAccessorGroup() === $this->_group);
	}
}  