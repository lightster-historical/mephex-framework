<?php


 
class Mephex_Controller_Action_Exception_ActionNotAccessibleTest
extends Mephex_Test_TestCase
{
	protected $_resource_list;
	protected $_controller;
	protected $_method_name;
	protected $_action_name;
	
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_method_name		= 'serveindex';
		$this->_action_name		= 'index';
		$this->_resource_list	= new Mephex_App_Resource_List();
		$this->_controller	= new Stub_Mephex_Controller_Action_Base(
			$this->_resource_list
		);
		
		$this->_exception	= new Mephex_Controller_Action_Exception_ActionNotAccessible
		(
			$this->_controller, 
			$this->_method_name, 
			$this->_action_name
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Controller_Action_Exception_ActionNotAccessible
	 */
    public function testExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    /**
	 * @covers Mephex_Controller_Action_Exception_ActionNotAccessible::__construct 
	 * @covers Mephex_Controller_Action_Exception_ActionNotAccessible::getController 
     */
    public function testControllerCanBeRetrieved()
    {
    	$this->assertTrue($this->_controller === $this->_exception->getController());
    }
    
    
    
    /**
	 * @covers Mephex_Controller_Action_Exception_ActionNotAccessible::__construct
	 * @covers Mephex_Controller_Action_Exception_ActionNotAccessible::getMethodName 
     */
    public function testMethodNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_method_name, $this->_exception->getMethodName());
    }
    
    
    
    /**
	 * @covers Mephex_Controller_Action_Exception_ActionNotAccessible::__construct
	 * @covers Mephex_Controller_Action_Exception_ActionNotAccessible::getActionName 
     */
    public function testActionNameCanBeRetrieved()
    {
    	$this->assertEquals($this->_action_name, $this->_exception->getActionName());
    }
}