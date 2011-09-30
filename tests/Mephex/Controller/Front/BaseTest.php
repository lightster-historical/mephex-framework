<?php



class Mephex_Controller_Front_BaseTest
extends Mephex_Test_TestCase
{
	protected function getFrontController($action_ctrl_name, $action_name)
	{
		return new Stub_Mephex_Controller_Front_Base(
			$action_ctrl_name, $action_name
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
			$this->getFrontController('', '')
			instanceof Mephex_Controller_Front_Base
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front_Base::getRouter
	 */
	public function testRouterIsLazyLoaded()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$action_name		= 'index';
		$front_ctrl			= $this->getFrontController(
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
			$action_ctrl_name,
			$action_name
		);

		$action_ctrl		= $front_ctrl->getActionController();

		$this->assertNull($action_ctrl->getActionName());
		$front_ctrl->run();
		$this->assertEquals($action_name, $action_ctrl->getActionName());
	}
}