<?php


 
class Mephex_Model_Stream_Exception_UnexpectedCriteriaTypeTest
extends Mephex_Test_TestCase
{
	protected $_reader;
	protected $_criteria;
	protected $_class_name;

	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_reader			= new Stub_Mephex_Model_Stream_Reader();
		$this->_criteria		= new Stub_Mephex_Model_Criteria();
		$this->_class_name		= 'Some_Entity_Class';
		
		$this->_exception	= new Mephex_Model_Stream_Exception_UnexpectedCriteriaType($this->_reader, $this->_criteria, $this->_class_name);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Stream_Exception_UnexpectedCriteriaType
	 */
    public function testExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    public function testReaderCanBeRetrieved()
    {
    	$this->assertTrue($this->_reader === $this->_exception->getReader());
    }
    
    
    
    public function testCriteriaCanBeRetrieved()
    {
    	$this->assertTrue($this->_criteria === $this->_exception->getCriteria());
    }
    
    
    
    public function testClassNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_class_name, $this->_exception->getClassName());
    }
}