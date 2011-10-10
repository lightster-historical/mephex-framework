<?php



class Mephex_Controller_Front_BaseTest
extends Mephex_Test_TestCase
{
	protected function getFrontController(
		Mephex_App_Arguments $arguments,
		$action_ctrl_name,
		$action_name
	)
	{
		return new Stub_Mephex_Controller_Front_Base(
			$arguments, $action_ctrl_name, $action_name
		);
	}



	/**
	 * @covers Mephex_Controller_Front
	 * @covers Mephex_Controller_Front_Base
	 * @covers Mephex_Controller_Front_Base::__construct
	 */
	public function testBaseFrontControllerCanBeInstantiated()
	{
		$this->assertTrue(
			$this->getFrontController(new Mephex_App_Arguments(), '', '')
			instanceof Mephex_Controller_Front_Base
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::__construct
	 * @covers Mephex_Controller_Front_Base::getArguments
	 */
	public function testArgumentsPassedToConstructorAreSameRetrieved()
	{
		$arguments			= new Mephex_App_Arguments();
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'index';
		$front_ctrl			= $this->getFrontController(
			$arguments,
			$action_ctrl_name,
			$action_name
		);

		$this->assertTrue($arguments === $front_ctrl->getArguments());
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::getRouter
	 */
	public function testRouterIsLazyLoaded()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'index';
		$front_ctrl			= $this->getFrontController(
			new Mephex_App_Arguments(),
			$action_ctrl_name,
			$action_name
		);
		$router		= $front_ctrl->getRouter();

		$this->assertTrue(
			$router === $front_ctrl->getRouter()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::generateActionController
	 */
	public function testActionControllerCanBeGenerated()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'index';
		$front_ctrl			= $this->getFrontController(
			new Mephex_App_Arguments(),
			$action_ctrl_name,
			$action_name
		);

		$this->assertTrue(
			$front_ctrl->generateActionController($action_ctrl_name)
			instanceof Mephex_Controller_Action_Base
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::getActionController
	 */
	public function testActionControllerIsLazyLoaded()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'index';
		$front_ctrl			= $this->getFrontController(
			new Mephex_App_Arguments(),
			$action_ctrl_name,
			$action_name
		);
		$action_ctrl		= $front_ctrl->getActionController();

		$this->assertTrue(
			$action_ctrl === $front_ctrl->getActionController()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::runAction
	 */
	public function testFrontControllerCanRunAction()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'list';
		$front_ctrl			= $this->getFrontController(
			new Mephex_App_Arguments(),
			$action_ctrl_name,
			$action_name
		);

		$action_ctrl		= $front_ctrl->getActionController();

		$this->assertNull($action_ctrl->getActionName());
		$front_ctrl->runAction($action_ctrl, $action_name);
		$this->assertEquals($action_name, $action_ctrl->getActionName());
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::run
	 */
	public function testFrontControllerRunsAction()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'builder';
		$front_ctrl			= $this->getFrontController(
			new Mephex_App_Arguments(),
			$action_ctrl_name,
			$action_name
		);

		$action_ctrl		= $front_ctrl->getActionController();

		$this->assertNull($action_ctrl->getActionName());
		$front_ctrl->run();
		$this->assertEquals($action_name, $action_ctrl->getActionName());
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::runWithRouterOverride
	 */
	public function testFrontControllerRouterCanBeOverridden()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'builder';
		$front_ctrl			= $this->getFrontController(
			new Mephex_App_Arguments(),
			$action_ctrl_name,
			$action_name
		);

		$override_action	= 'index';
		$router				= new Stub_Mephex_Controller_Router(
			$action_ctrl_name,
			$override_action
		);

		$action_ctrl		= $front_ctrl->getActionController();

		$this->assertNotEquals($override_action, $action_name);
		$this->assertNull($action_ctrl->getActionName());
		$front_ctrl->runWithRouterOverride($router);
		$this->assertEquals($override_action, $action_ctrl->getActionName());
	}
}