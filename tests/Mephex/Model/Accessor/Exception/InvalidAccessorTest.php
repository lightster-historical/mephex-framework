<?php


 
class Mephex_Model_Entity_Accessor_Exception_InvalidAccessorTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_accessor_name;
	protected $_accessor;
	
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_group			= new Stub_Mephex_Model_Accessor_Group();
		$this->_accessor_name	= 'Some_Accessor';
		$this->_accessor		= new Stub_Mephex_Model_Accessor(
			$this->_group,
			new Stub_Mephex_Model_Mapper($this->_group)
		);
		
		$this->_exception		= new Mephex_Model_Accessor_Exception_InvalidAccessor($this->_group, $this->_accessor_name, $this->_accessor);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Accessor_Exception_InvalidAccessor
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
    
    
    
    public function testAccessorCanBeRetrieved()
    {
    	$this->assertTrue($this->_accessor === $this->_exception->getAccessor());
    }
}