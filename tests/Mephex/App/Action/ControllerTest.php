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
	
	
	
	/**
	 * @covers Mephex_App_Action_Controller::processPreAction
	 * @depends testActionMethodCanBeCalled
	 */
	public function testProcessPreActionIsCalledBeforeActionAndPostAction()
	{
		$this->_controller	= new Stub_Mephex_App_Action_Controller_PreProcess();
		
		$this->assertFalse($this->_controller->isPreActionProcessed());
		$this->assertFalse($this->_controller->isPostActionProcessed());
		
		try
		{
			$this->_controller->runAction('index');
		}
		catch(Stub_Mephex_App_Action_Exception_PreProcessTestException $ex)
		{
		}
		
		$this->assertTrue($this->_controller->isPreActionProcessed());
		$this->assertEquals('index', $this->_controller->getActionName());
		$this->assertFalse($this->_controller->isPostActionProcessed());
	}
	
	
	
	/**
	 * @covers Mephex_App_Action_Controller::processPostAction
	 * @depends testActionMethodCanBeCalled
	 */
	public function testProcessPostActionIsCalledAfterPreActionAndAction()
	{
		$this->_controller	= new Stub_Mephex_App_Action_Controller_PostProcess();
		
		$this->assertFalse($this->_controller->isPreActionProcessed());
		$this->assertFalse($this->_controller->isPostActionProcessed());
		
		try
		{
			$this->_controller->runAction('index');
		}
		catch(Stub_Mephex_App_Action_Exception_PostProcessTestException $ex)
		{
		}
		
		$this->assertTrue($this->_controller->isPreActionProcessed());
		$this->assertEquals('index', $this->_controller->getActionName());
		$this->assertTrue($this->_controller->isPostActionProcessed());
	}
}