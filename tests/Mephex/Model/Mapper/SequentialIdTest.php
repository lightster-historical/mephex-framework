<?php



class Mephex_Model_Mapper_SequentialIdTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_mapper;
	
	
	
	public function setUp()
	{
		$this->_group	= new Stub_Mephex_Model_Accessor_Group();
		$this->_mapper	= new Stub_Mephex_Model_Mapper_SequentialId($this->_group);
	}
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_mapper instanceof Mephex_Model_Mapper_SequentialId);
	}
	
	
	
	public function testRetrieveAccessorGroupIsTheSameObjectPassedToTheConstructor()
	{
		$this->assertTrue($this->_mapper->getAccessorGroup() === $this->_group);
	}
	
	
	
	public function testIdIsProperlyUpdatedWhenANewEntityIsProcessed()
	{
		$entity	= new Stub_Mephex_Model_Entity();
		$entity->setId(5);
		
		$this->assertEquals(5, $entity->getId());
		
		$this->_mapper->processNewEntity($entity, 12);
		
		$this->assertEquals(12, $entity->getId());
	}
}  