<?php


 
class Mephex_Model_Entity_Accessor_Exception_DuplicateEntityCacheTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_class_name;
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_group		= new Stub_Mephex_Model_Accessor_Group();
		$this->_class_name	= 'Some_Entity_Class';
		$this->_exception	= new Mephex_Model_Accessor_Exception_DuplicateEntityCache($this->_group, $this->_class_name);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Accessor_Exception_DuplicateEntityCache
	 */
    public function testExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    public function testAccessorGroupCanBeRetrieved()
    {
    	$this->assertTrue($this->_group === $this->_exception->getAccessorGroup());
    }
    
    
    
    public function testClassNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_class_name, $this->_exception->getClassName());
    }
}