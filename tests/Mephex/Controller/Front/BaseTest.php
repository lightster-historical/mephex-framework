<?php



class Mephex_Controller_Front_BaseTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_Controller_Front_Base::__construct
	 */
	public function testBaseFrontControllerCanBeInstantiated()
	{
		$this->assertInstanceOf(
			'Mephex_Controller_Front_Base',
			new Mephex_Controller_Front_Base(new Mephex_App_Resource_List())
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Base::__construct
	 */
	public function testConstructorSetsResourceList()
	{
		$resource_list		= new Mephex_App_Resource_List();
		$front_ctrl			= new Mephex_Controller_Front_Base($resource_list);

		$this->assertAttributeSame(
			$resource_list,
			'_resource_list',
			$front_ctrl
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Base::getResourceList
	 * @depends testConstructorSetsResourceList
	 */
	public function testResourceListPassedToConstructorIsSameRetrieved()
	{
		$resource_list		= new Mephex_App_Resource_List();
		$front_ctrl			= new Mephex_Controller_Front_Base($resource_list);

		$this->assertSame(
			$resource_list,
			$front_ctrl->getResourceList()
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Base::run
	 */
	public function testRunCallsGetActionController()
	{
		$action_name	= 'serveSomeContent';

		$front_ctrl			= $this->getMock(
			'Stub_Mephex_Controller_Front_Base',
			array(
				'getRouter',
				'getActionController',
				'getActionName'
			),
			array(
				new Mephex_App_Resource_List()
			)
		);
		$router				= $this->getMock(
			'Mephex_Controller_Router'
		);
		$action_ctrl		= $this->getMock(
			'Mephex_Controller_Action'
		);

		$front_ctrl
			->expects($this->once())
			->method('getRouter')
			->will($this->returnValue($router));
		$front_ctrl
			->expects($this->once())
			->method('getActionController')
			->with($this->equalTo($router))
			->will($this->returnValue($action_ctrl));

		$front_ctrl->run();
	}



	/**
	 * @covers Mephex_Controller_Front_Base::run
	 * @depends testRunCallsGetActionController
	 */
	public function testRunGetsActionNameFromRouter()
	{
		$action_name	= 'serveSomeContent';

		$router				= $this->getMock(
			'Mephex_Controller_Router'
		);
		$router
			->expects($this->once())
			->method('getActionName')
			->will($this->returnValue($action_name));

		$front_ctrl			= $this->getMock(
			'Stub_Mephex_Controller_Front_Base',
			array(
				'getRouter',
				'getActionController',
			),
			array(
				new Mephex_App_Resource_List()
			)
		);

		$action_ctrl		= $this->getMock(
			'Mephex_Controller_Action',
			array(
				'runAction'
			)
		);

		$front_ctrl
			->expects($this->once())
			->method('getRouter')
			->will($this->returnValue($router));
		$front_ctrl
			->expects($this->once())
			->method('getActionController')
			->with($this->equalTo($router))
			->will($this->returnValue($action_ctrl));

		$front_ctrl->run();
	}



	/**
	 * @covers Mephex_Controller_Front_Base::run
	 * @depends testRunCallsGetActionController
	 */
	public function testRunCallsActionControllerRunAction()
	{
		$action_name	= 'serveSomeContent';

		$router				= $this->getMock(
			'Mephex_Controller_Router'
		);
		$router
			->expects($this->once())
			->method('getActionName')
			->will($this->returnValue($action_name));

		$front_ctrl			= $this->getMock(
			'Stub_Mephex_Controller_Front_Base',
			array(
				'getRouter',
				'getActionController',
			),
			array(
				new Mephex_App_Resource_List()
			)
		);

		$action_ctrl		= $this->getMock(
			'Mephex_Controller_Action',
			array(
				'runAction'
			)
		);
		$action_ctrl
			->expects($this->once())
			->method('runAction')
			->with($this->equalTo($action_name));

		$front_ctrl
			->expects($this->once())
			->method('getRouter')
			->will($this->returnValue($router));
		$front_ctrl
			->expects($this->once())
			->method('getActionController')
			->with($this->equalTo($router))
			->will($this->returnValue($action_ctrl));

		$front_ctrl->run();
	}



	/**
	 * @covers Mephex_Controller_Front_Base::getRouter
	 */
	public function testGetRouterRetrievesRouterFromResourceList()
	{
		$resource_list		= $this->getMock(
			'Mephex_App_Resource_List',
			array(
				'checkResourceType'
			)
		);
		$router			= $this->getMock(
			'Mephex_Controller_Router'
		);

		$resource_list
			->expects($this->once())
			->method('checkResourceType')
			->with(
				$this->equalTo('Router'),
				$this->equalTo('Default'),
				$this->equalTo('Mephex_Controller_Router')
			)
			->will($this->returnValue($router));

		$front_ctrl	= new Stub_Mephex_Controller_Front_Base($resource_list);
		$front_ctrl->getRouter();
	}



	/**
	 * @covers Mephex_Controller_Front_Base::generateActionController
	 */
	public function testGenerateActionControllerInstantiatesClass()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$resource_list		= new Mephex_App_Resource_List();
		$front_ctrl			= new Stub_Mephex_Controller_Front_Base($resource_list);

		$this->assertInstanceOf(
			'Stub_Mephex_Controller_Action_Base',
			$front_ctrl->generateActionController($action_ctrl_name)
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Base::generateActionController
	 * @depends testGenerateActionControllerInstantiatesClass
	 */
	public function testGeneratedActionControllerReceivesResourceList()
	{
		$action_ctrl_name	= 'Stub_Mephex_Controller_Action_Base';
		$resource_list		= new Mephex_App_Resource_List();
		$front_ctrl			= new Stub_Mephex_Controller_Front_Base($resource_list);
		$action_ctrl		= $front_ctrl->generateActionController($action_ctrl_name);

		$this->assertSame(
			$resource_list,
			$action_ctrl->getResourceList()
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Base::getActionController
	 */
	public function testGetActionControllerGetsClassNameFromRouter()
	{
		$front_ctrl	= $this->getMock(
			'Stub_Mephex_Controller_Front_Base',
			array(
				'generateActionController',
			),
			array(
				new Mephex_App_Resource_List(),
			)
		);

		$router				= $this->getMock('Mephex_Controller_Router');
		$router
			->expects($this->once())
			->method('getClassName')
			->will($this->returnValue('Mephex_Controller_Action_Base'));

		$front_ctrl->getActionController($router);
	}



	/**
	 * @covers Mephex_Controller_Front_Base::getActionController
	 * @expectedException Mephex_Reflection_Exception_UnexpectedClass
	 */
	public function testGetActionControllerChecksClassType()
	{
		$front_ctrl	= $this->getMock(
			'Stub_Mephex_Controller_Front_Base',
			array(
				'generateActionController',
			),
			array(
				new Mephex_App_Resource_List(),
			)
		);

		$router				= $this->getMock('Mephex_Controller_Router');
		$router
			->expects($this->once())
			->method('getClassName')
			->will($this->returnValue('Mephex_Controller_Front'));

		$front_ctrl->getActionController($router);
	}



	/**
	 * @covers Mephex_Controller_Front_Base::getActionController
	 * @depends testGetActionControllerChecksClassType
	 */
	public function testGetActionControllerCallsGenerateActionController()
	{
		$action_ctrl_name	= 'Mephex_Controller_Action_Base';

		$front_ctrl	= $this->getMock(
			'Stub_Mephex_Controller_Front_Base',
			array(
				'generateActionController',
			),
			array(
				new Mephex_App_Resource_List(),
			)
		);
		$front_ctrl
			->expects($this->once())
			->method('generateActionController')
			->with($this->equalTo($action_ctrl_name));

		$router				= $this->getMock('Mephex_Controller_Router');
		$router
			->expects($this->once())
			->method('getClassName')
			->will($this->returnValue($action_ctrl_name));

		$front_ctrl->getActionController($router);
	}
}