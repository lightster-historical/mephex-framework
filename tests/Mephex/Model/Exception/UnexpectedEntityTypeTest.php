<?php


 
class Mephex_Model_Entity_Exception_UnexpectedEntityTypeTest
extends Mephex_Test_TestCase
{
	protected $_entity;
	protected $_class_name;
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_entity		= new Stub_Mephex_Model_Entity();
		$this->_class_name	= 'Some_Entity_Class';
		$this->_exception	= new Mephex_Model_Exception_UnexpectedEntityType($this->_entity, $this->_class_name);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Exception_UnexpectedEntityType
	 */
    public function testExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    public function testEntityCanBeRetrieved()
    {
    	$this->assertTrue($this->_entity === $this->_exception->getEntity());
    }
    
    
    
    public function testClassNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_class_name, $this->_exception->getClassName());
    }
}