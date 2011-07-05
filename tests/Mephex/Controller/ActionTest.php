<?php



class Mephex_Controller_ActionTest
extends Mephex_Test_TestCase
{
	protected $_controller;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_controller	= new Stub_Mephex_Controller_Action();
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action::getActionMethodName
	 */
	public function testActionMethodNameCanBeRetrieved()
	{
		$this->assertEquals('serveindex', $this->_controller->getActionMethodName('index'));
		$this->assertEquals('servelist', $this->_controller->getActionMethodName('list'));
		$this->assertEquals('servebuilder', $this->_controller->getActionMethodName('builder'));
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action::runAction
	 * @covers Mephex_Controller_Action::processAction
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
	 * @covers Mephex_Controller_Action::runAction
	 * @covers Mephex_Controller_Action::processAction
	 * @expectedException Mephex_Controller_Action_Exception_ActionNotFound
	 */
	public function testCallingAnUnknownActionThrowsAnException()
	{
		$this->_controller->runAction('unknown');
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action::runAction
	 * @covers Mephex_Controller_Action::processAction
	 * @expectedException Mephex_Controller_Action_Exception_ActionNotAccessible
	 */
	public function testCallingAnInaccessibleActionThrowsAnException()
	{
		$this->_controller->runAction('inaccessible');
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action::processPreAction
	 * @depends testActionMethodCanBeCalled
	 */
	public function testProcessPreActionIsCalledBeforeActionAndPostAction()
	{
		$this->_controller	= new Stub_Mephex_Controller_Action_PreProcess();
		
		$this->assertFalse($this->_controller->isPreActionProcessed());
		$this->assertFalse($this->_controller->isPostActionProcessed());
		
		try
		{
			$this->_controller->runAction('index');
		}
		catch(Stub_Mephex_Controller_Exception_PreProcessTestException $ex)
		{
		}
		
		$this->assertTrue($this->_controller->isPreActionProcessed());
		$this->assertEquals('index', $this->_controller->getActionName());
		$this->assertFalse($this->_controller->isPostActionProcessed());
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action::processPostAction
	 * @depends testActionMethodCanBeCalled
	 */
	public function testProcessPostActionIsCalledAfterPreActionAndAction()
	{
		$this->_controller	= new Stub_Mephex_Controller_Action_PostProcess();
		
		$this->assertFalse($this->_controller->isPreActionProcessed());
		$this->assertFalse($this->_controller->isPostActionProcessed());
		
		try
		{
			$this->_controller->runAction('index');
		}
		catch(Stub_Mephex_Controller_Exception_PostProcessTestException $ex)
		{
		}
		
		$this->assertTrue($this->_controller->isPreActionProcessed());
		$this->assertEquals('index', $this->_controller->getActionName());
		$this->assertTrue($this->_controller->isPostActionProcessed());
	}
}