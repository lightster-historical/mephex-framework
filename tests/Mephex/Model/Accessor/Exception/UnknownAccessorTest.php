<?php


 
class Mephex_Model_Entity_Accessor_Exception_UnknownAccessorTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_accessor_name;
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_group			= new Stub_Mephex_Model_Accessor_Group();
		$this->_accessor_name	= 'Some_Accessor';
		$this->_exception		= new Mephex_Model_Accessor_Exception_UnknownReader($this->_group, $this->_accessor_name);
	}
    
    
    
    public function testExceptionIsASubclassOfUnknownAccessor()
    {
    	// if not, we wouldn't actually be testing UnknownAccessor
    	$this->assertTrue($this->_exception instanceof Mephex_Model_Accessor_Exception_UnknownAccessor);
    }
	
	
	
	/**
	 * @expectedException Mephex_Model_Accessor_Exception_UnknownAccessor
	 */
    public function testExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    public function testAccessorGroupCanBeRetrieved()
    {
    	$this->assertTrue($this->_group === $this->_exception->getAccessorGroup());
    }
    
    
    
    public function testAccessorNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_accessor_name, $this->_exception->getAccessorName());
    }
}