<?php


 
class Mephex_Model_Entity_Exception_UnknownPropertyTest
extends Mephex_Test_TestCase
{
	protected $_entity;
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_entity		= new Stub_Mephex_Model_Entity();
		$this->_exception	= new Mephex_Model_Entity_Exception_UnknownProperty($this->_entity, 'UndefProp');
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Entity_Exception_UnknownProperty
	 */
    public function testEntityUnknownPropertyExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    public function testEntityCanBeRetrieved()
    {
    	$this->assertTrue($this->_entity === $this->_exception->getEntity());
    }
    
    
    
    public function testPropertyNameCanBeRetrieved()
    {
    	$this->assertEquals('UndefProp', $this->_exception->getPropertyName());
    }
}