<?php



class Mephex_Model_EntityTest
extends Mephex_Test_TestCase
{
	protected $_entity;
	
	protected $_group;
	protected $_stream;
	protected $_mapper;
	protected $_accessor;
	
	protected $_reference;
	
	protected $_criteria;
	
	
	
	public function setUp()
	{
		$this->_entity		= new Stub_Mephex_Model_Entity();
		
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
	
	
	
	public function testEntityPropertiesCanBeRetrieved()
	{
		$this->assertNull($this->_entity->getId());
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Entity_Exception_UnknownProperty
	 */
	public function testRetrievingAnUndefinedEntityPropertyThrowsAnException()
	{
		$this->_entity->getUndefinedProperty();
	}
	
	
	
	/**
	 * @depends testEntityPropertiesCanBeRetrieved
	 */
	public function testEntityPropertiesCanBeSet()
	{
		$this->_entity->setId(5);
		$this->assertEquals(5, $this->_entity->getId());
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Entity_Exception_UnknownProperty
	 */
	public function testSettingAnUndefinedPropertyThrowsAnException()
	{
		$this->_entity->setUndefinedProperty('test');
	}
	
	
	
    public function testAnEntityIsMarkedNewByDefault()
    {
    	$this->assertTrue($this->_entity->isMarkedNew());
    	$this->assertFalse($this->_entity->isMarkedClean());
    	$this->assertFalse($this->_entity->isMarkedDeleted());
    	$this->assertFalse($this->_entity->isMarkedDirty());
    }
    
    
    
    public function testAnEntityCanBeMarkedClean()
    {
    	$this->_entity->markClean();
    	$this->assertTrue($this->_entity->isMarkedClean());
    }
    
    
    
    /**
     * @depends testAnEntityCanBeMarkedClean
     */
    public function testAnEntityCanBeMarkedNew()
    {
    	$this->_entity->markClean();
    	$this->assertTrue($this->_entity->isMarkedClean());
    	$this->_entity->markNew();
    	$this->assertTrue($this->_entity->isMarkedNew());
    }
    
    
    
    public function testAnEntityCanBeMarkedDeleted()
    {
    	$this->_entity->markDeleted();
    	$this->assertTrue($this->_entity->isMarkedDeleted());
    }
    
    
    
    public function testAnEntityCanBeMarkedDirty()
    {
    	$this->_entity->markDirty();
    	$this->assertTrue($this->_entity->isMarkedDirty());
    }
    
    
    
    public function testAnInstanceOfTheUnitTestEntityStubIsAnInstanceOfItsOwnClass()
    {
    	$this->assertTrue
    	(
    		Mephex_Model_Entity::checkEntityType
    		(
    			$this->_entity,
    			'Stub_Mephex_Model_Entity'
    		)
    	);
    }
    
    
    
    public function testAnInstanceOfTheUnitTestEntityStubIsAnInstanceOfTheBaseEntityClass()
    {
    	$this->assertTrue
    	(
    		Mephex_Model_Entity::checkEntityType
    		(
    			$this->_entity,
    			'Mephex_Model_Entity'
    		)
    	);
    }
    
    
    
    /**
     * @expectedException Mephex_Model_Exception_UnexpectedEntityType
     */
    public function testCheckingAnEntityAgainstANonParentClassThrowsAnException()
    {
    	$this->assertTrue
    	(
    		Mephex_Model_Entity::checkEntityType
    		(
    			$this->_entity,
    			'Mephex_Test_TestCase'
    		)
    	);	
    }
    
    
    
    public function testPropertiesCannotBeSetByReferenceByDefault()
    {
    	$this->assertFalse($this->_entity->isReferencedPropertyAllowed('NoWay'));
    }
    
    
    
    public function testRetrievingAReferencePropertyReturnsAnEntity()
    {
    	$this->_entity->setReferencedProperty('parent', $this->_reference);
    	$this->assertTrue($this->_entity->getParent() instanceof Mephex_Model_Entity);
    }
    
    
    
    public function testRetrievingAReferenceOnlyPropertyReturnsAnEntity()
    {
    	$this->_entity->setReferencedProperty('referenceOnly', $this->_reference);
    	$this->assertTrue($this->_entity->getReferenceOnly() instanceof Mephex_Model_Entity);
    }
    
    
    
    /**
     * @expectedException Mephex_Model_Exception_UnallowedReference
     */
    public function testSettingAPropertyByReferenceWhenNotAllowedThrowsAnException()
    {
    	$this->_entity->setReferencedProperty('id', $this->_reference);
    }
    
    
    
    public function testSettingAPropertyReturnsOwnerObject()
    {
    	$this->assertTrue($this->_entity->setProperty('id', 24) === $this->_entity);
    }
    
    
    
    public function testSettingAReferencedPropertyReturnsOwnerObject()
    {
    	$this->assertTrue(
    		$this->_entity->setReferencedProperty('parent', $this->_reference)
    			=== $this->_entity
    	);
    }
}