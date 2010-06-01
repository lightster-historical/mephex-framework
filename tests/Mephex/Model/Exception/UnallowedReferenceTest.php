<?php


 
class Mephex_Model_Entity_Exception_UnallowedReferenceTest
extends Mephex_Test_TestCase
{
	protected $_entity;
	protected $_property_name;
	protected $_reference;

	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_entity			= new Stub_Mephex_Model_Entity();
		$this->_property_name	= 'someProperty';
		
		$group		= new Stub_Mephex_Model_Accessor_Group();
		$cache		= new Stub_Mephex_Model_Cache();
		$stream		= new Stub_Mephex_Model_Stream_Reader();
		$mapper		= new Stub_Mephex_Model_Mapper($group);
		$reader		= new Stub_Mephex_Model_Accessor_Reader
		(
			$group,
			$mapper,
			$cache,
			$stream
		);		
		$criteria	= new Mephex_Model_Criteria_Array(array('Id' => 6));
		$this->_reference	= new Mephex_Model_Entity_Reference($reader, $criteria);
		
		$this->_exception	= new Mephex_Model_Exception_UnallowedReference($this->_entity, $this->_property_name, $this->_reference);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Exception_UnallowedReference
	 */
    public function testExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    public function testEntityCanBeRetrieved()
    {
    	$this->assertTrue($this->_entity === $this->_exception->getEntity());
    }
    
    
    
    public function testPropertyNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_property_name, $this->_exception->getPropertyName());
    }
    
    
    
    public function testReferenceCanBeRetrieved()
    {
    	$this->assertTrue($this->_reference === $this->_exception->getReference());
    }
}