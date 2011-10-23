<?php



class Mephex_Controller_Action_BaseTest
extends Mephex_Test_TestCase
{
	protected $_arguments;
	protected $_front_ctrl;
	protected $_controller;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_arguments	= new Mephex_App_Arguments();
		$this->_front_ctrl	= new Stub_Mephex_Controller_Front_Base(
			$this->_arguments, 'Stub_Mephex_Controller_Action_Base', 'index'
		);
		$this->_controller	= new Stub_Mephex_Controller_Action_Base(
			$this->_front_ctrl
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action
	 * @covers Mephex_Controller_Action_Base::__construct
	 */
	public function testBaseControllerExtendsActionController()
	{
		$this->assertTrue($this->_controller instanceof Mephex_Controller_Action);
	}



	/**
	 * @covers Mephex_Controller_Action_Base::__construct
	 * @covers Mephex_Controller_Action_Base::getFrontController
	 */
	public function testFrontControllerPassedToActionControllerConstructorIsReturnedByGetter()
	{
		$this->assertTrue($this->_front_ctrl === $this->_controller->getFrontController());
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Base::getActionMethodName
	 */
	public function testActionMethodNameCanBeRetrieved()
	{
		$this->assertEquals('serveindex', $this->_controller->getActionMethodName('index'));
		$this->assertEquals('servelist', $this->_controller->getActionMethodName('list'));
		$this->assertEquals('servebuilder', $this->_controller->getActionMethodName('builder'));
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Base::runAction
	 * @covers Mephex_Controller_Action_Base::processAction
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
	 * @covers Mephex_Controller_Action_Base::runAction
	 * @covers Mephex_Controller_Action_Base::processAction
	 * @expectedException Mephex_Controller_Action_Exception_ActionNotFound
	 */
	public function testCallingAnUnknownActionThrowsAnException()
	{
		$this->_controller->runAction('unknown');
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Base::runAction
	 * @covers Mephex_Controller_Action_Base::processAction
	 * @expectedException Mephex_Controller_Action_Exception_ActionNotAccessible
	 */
	public function testCallingAnInaccessibleActionThrowsAnException()
	{
		$this->_controller->runAction('inaccessible');
	}



	/**
	 * @covers Mephex_Controller_Action_Base::getExpectedArgumentsClass
	 */
	public function testExpectedArgumentsClassIsAppArgumentsClass()
	{
		$this->assertEquals(
			'Mephex_App_Arguments',
			$this->_controller->getExpectedArgumentsClass()
		);
	}



	/**
	 * @covers Mephex_Controller_Action_Base::checkArguments
	 * @expectedException Mephex_Reflection_Exception_ExpectedObject
	 */
	public function testArgumentsClassCanBeChecked()
	{
		$this->_controller	= new Stub_Mephex_Controller_Action_Base(
			$this->_front_ctrl,
			'Mephex_App_Arguments_Http'
		);
		$this->_controller->checkArguments(new Mephex_App_Arguments());
	}



	/**
	 * @covers Mephex_Controller_Action_Base::checkArguments
	 */
	public function testArgumentsClassIsCheckedBeforeProcessingPreAction()
	{
		$this->_controller	= new Stub_Mephex_Controller_Action_Base(
			$this->_front_ctrl,
			'Mephex_App_Arguments_Http'
		);

		$exception_thrown	= false;
		try
		{
			$this->_controller->runAction('index');
		}
		catch(Mephex_Reflection_Exception_ExpectedObject $ex)
		{
			$exception_thrown	= true;
		}

		$this->assertTrue($exception_thrown);
		$this->assertFalse($this->_controller->isPreActionProcessed());
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Base::processPreAction
	 * @depends testActionMethodCanBeCalled
	 */
	public function testProcessPreActionIsCalledBeforeActionAndPostAction()
	{
		$this->_controller	= new Stub_Mephex_Controller_Action_PreProcess(
			$this->_front_ctrl
		);
		
		$this->assertFalse($this->_controller->isPreActionProcessed());
		$this->assertFalse($this->_controller->isPostActionProcessed());
		
		try
		{
			$this->_controller->runAction('index');
		}
		catch(Stub_Mephex_Controller_Action_Exception_PreProcessTestException $ex)
		{
		}
		
		$this->assertTrue($this->_controller->isPreActionProcessed());
		$this->assertEquals('index', $this->_controller->getActionName());
		$this->assertFalse($this->_controller->isPostActionProcessed());
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Base::processPostAction
	 * @depends testActionMethodCanBeCalled
	 */
	public function testProcessPostActionIsCalledAfterPreActionAndAction()
	{
		$this->_controller	= new Stub_Mephex_Controller_Action_PostProcess(
			$this->_front_ctrl
		);
		
		$this->assertFalse($this->_controller->isPreActionProcessed());
		$this->assertFalse($this->_controller->isPostActionProcessed());
		
		try
		{
			$this->_controller->runAction('index');
		}
		catch(Stub_Mephex_Controller_Action_Exception_PostProcessTestException $ex)
		{
		}
		
		$this->assertTrue($this->_controller->isPreActionProcessed());
		$this->assertEquals('index', $this->_controller->getActionName());
		$this->assertTrue($this->_controller->isPostActionProcessed());
	}
}