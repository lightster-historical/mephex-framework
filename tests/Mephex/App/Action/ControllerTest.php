<?php



class Mephex_App_Action_ControllerTest
extends Mephex_Test_TestCase
{
	protected $_controller;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_controller	= new Stub_Mephex_App_Action_Controller();
	}
	
	
	
	/**
	 * @covers Mephex_App_Action_Controller::getActionMethodName
	 */
	public function testActionMethodNameCanBeRetrieved()
	{
		$this->assertEquals('serveindex', $this->_controller->getActionMethodName('index'));
		$this->assertEquals('servelist', $this->_controller->getActionMethodName('list'));
		$this->assertEquals('servebuilder', $this->_controller->getActionMethodName('builder'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Action_Controller::runAction
	 * @covers Mephex_App_Action_Controller::processAction
	 */
	public function testActionMethodCanBeCalled()
	{
		$this->_controller->runAction('index');
		$this->assertEquals('index', $this->_controller->getActionName());
		
		$this->_controller->runAction('list');
		$this->assertEquals('list', $this->_controller->getActionName());
		
		$this->_controller->runAction('builder');
		$this->assertEquals('builder', $this->_controller->getActionName());
	}
	
	
	
	/**
	 * @covers Mephex_App_Action_Controller::runAction
	 * @covers Mephex_App_Action_Controller::processAction
	 * @expectedException Mephex_App_Action_Controller_Exception_ActionNotFound
	 */
	public function testCallingAnUnknownActionThrowsAnException()
	{
		$this->_controller->runAction('unknown');
	}
	
	
	
	/**
	 * @covers Mephex_App_Action_Controller::runAction
	 * @covers Mephex_App_Action_Controller::processAction
	 * @expectedException Mephex_App_Action_Controller_Exception_ActionNotAccessible
	 */
	public function testCallingAnInaccessibleActionThrowsAnException()
	{
		$this->_controller->runAction('inaccessible');
	}
}