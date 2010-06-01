<?php



class Mephex_Model_AccessorTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_mapper;
	
	protected $_accessor;
	
	
	
	public function setUp()
	{
		$this->_group		= new Stub_Mephex_Model_Accessor_Group();
		$this->_mapper		= new Stub_Mephex_Model_Mapper($this->_group);
		
		$this->_accessor	= new Stub_Mephex_Model_Accessor($this->_group, $this->_mapper);		
	} 
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_accessor instanceof Mephex_Model_Accessor);
	}
	
	
	
	public function testTheAccessorGroupGetterReturnsTheSameObjectPassedToTheConstructor()
	{
		$this->assertTrue($this->_group === $this->_accessor->getAccessorGroup());
	}
	
	
	
	public function testThMapperGetterReturnsTheSameObjectPassedToTheConstructor()
	{
		$this->assertTrue($this->_mapper === $this->_accessor->getMapper());
	}
}  