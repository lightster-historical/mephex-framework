<?php


 
class Mephex_App_Action_Controller_Exception_ActionNotFoundTest
extends Mephex_Test_TestCase
{
	protected $_controller;
	protected $_method_name;
	protected $_action_name;
	
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_controller	= new Stub_Mephex_App_Action_Controller();
		$this->_method_name	= 'serveindex';
		$this->_action_name	= 'index';
		
		$this->_exception	= new Mephex_App_Action_Controller_Exception_ActionNotFound
		(
			$this->_controller, 
			$this->_method_name, 
			$this->_action_name
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_App_Action_Controller_Exception_ActionNotFound
	 */
    public function testExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    /**
	 * @covers Mephex_App_Action_Controller_Exception_ActionNotFound::__construct 
	 * @covers Mephex_App_Action_Controller_Exception_ActionNotFound::getController 
     */
    public function testControllerCanBeRetrieved()
    {
    	$this->assertTrue($this->_controller === $this->_exception->getController());
    }
    
    
    
    /**
	 * @covers Mephex_App_Action_Controller_Exception_ActionNotFound::__construct
	 * @covers Mephex_App_Action_Controller_Exception_ActionNotFound::getMethodName 
     */
    public function testMethodNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_method_name, $this->_exception->getMethodName());
    }
    
    
    
    /**
	 * @covers Mephex_App_Action_Controller_Exception_ActionNotFound::__construct
	 * @covers Mephex_App_Action_Controller_Exception_ActionNotFound::getActionName 
     */
    public function testActionNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_action_name, $this->_exception->getActionName());
    }
}