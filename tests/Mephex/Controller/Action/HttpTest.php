<?php



class Mephex_Controller_Action_HttpTest
extends Mephex_Test_TestCase
{
	protected $_http_info;
	protected $_post_request;
	protected $_get_request;
	protected $_arguments;

	protected $_front_ctrl;
	protected $_controller;
	
	protected $_exception;
	
	
	
	protected function setUp()
	{
		parent::setUp();

		$this->_http_info		= new Mephex_App_Arguments_HttpConnection(array(
			'unitTesting'	=> 'SERVER'
		));
		$this->_post_request	= new Mephex_App_Arguments(array(
			'unitTesting'	=> 'POST'
		));
		$this->_get_request	= new Mephex_App_Arguments(array(
			'unitTesting'	=> 'GET'
		));

		$this->_resource_list	= new Mephex_App_Resource_List();
		$this->_resource_list->addType('Arguments', 'Mephex_App_Arguments');
		$this->_resource_list->addResource(
			'Arguments',
			'HttpConnectionInfo',
			$this->_http_info
		);
		$this->_resource_list->addResource(
			'Arguments',
			'PostRequest',
			$this->_post_request
		);
		$this->_resource_list->addResource(
			'Arguments',
			'GetRequest',
			$this->_get_request
		);

		$this->_controller	= new Stub_Mephex_Controller_Action_Http(
			$this->_resource_list
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::__construct
	 */
	public function testHttpControllerExtendsBaseActionController()
	{
		$this->assertTrue($this->_controller instanceof Mephex_Controller_Action_Base);
	}



	/**
	 * @covers Mephex_Controller_Action_Http::processPreAction
	 */
	public function testArgumentsTypeResourceTypeIsCheckedByPreAction()
	{
		$resource_list	= new Mephex_App_Resource_List();
		$resource_list->addType('Arguments', 'Mephex_Config_OptionSet');
		$controller		= new Stub_Mephex_Controller_Action_Http(
			$resource_list
		);

		try
		{
			$controller->processPreAction();
		}
		catch(Mephex_Reflection_Exception_UnexpectedClass $ex)
		{
			$this->assertEquals(
				'Mephex_App_Arguments',
				$ex->getExpectedClass()
			);
		}
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::processPreAction
	 * @covers Mephex_Controller_Action_Http::getHttpConnectionInfo
	 */
	public function testHttpConnectionInfoIsMadeAvailableAfterPreAction()
	{
		$this->assertNull($this->_controller->getHttpConnectionInfo());
		$this->_controller->processPreAction();

		$args	= $this->_controller->getHttpConnectionInfo();
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('SERVER', $args->get('unitTesting'));
	}



	/**
	 * @covers Mephex_Controller_Action_Http::processPreAction
	 */
	public function testHttpConnectionInfoResourceTypeIsCheckedByPreAction()
	{
		$resource_list	= new Mephex_App_Resource_List();
		$resource_list->addType('Arguments', 'Mephex_App_Arguments');
		$controller		= new Stub_Mephex_Controller_Action_Http(
			$resource_list
		);
		$resource_list->addResource(
			'Arguments',
			'HttpConnectionInfo',
			new Mephex_App_Arguments()
		);
		$resource_list->addResource(
			'Arguments',
			'PostRequest',
			$this->_post_request
		);
		$resource_list->addResource(
			'Arguments',
			'GetRequest',
			$this->_get_request
		);

		try
		{
			$controller->processPreAction();
		}
		catch(Mephex_Reflection_Exception_ExpectedObject $ex)
		{
			$this->assertEquals(
				'Mephex_App_Arguments_HttpConnection',
				$ex->getExpectedClass()
			);
		}
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::processPreAction
	 * @covers Mephex_Controller_Action_Http::getPostRequest
	 */
	public function testPostRequestIsMadeAvailableAfterPreAction()
	{
		$this->assertNull($this->_controller->getPostRequest());
		$this->_controller->processPreAction();

		$args	= $this->_controller->getPostRequest();
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('POST', $args->get('unitTesting'));
	}



	/**
	 * @covers Mephex_Controller_Action_Http::processPreAction
	 */
	public function testPostRequestResourceTypeIsCheckedByPreAction()
	{
		$resource_list	= new Mephex_App_Resource_List();
		$resource_list->addType('Arguments', 'Mephex_App_Arguments');
		$controller		= new Stub_Mephex_Controller_Action_Http(
			$resource_list
		);
		$resource_list->addResource(
			'Arguments',
			'HttpConnectionInfo',
			$this->_http_info
		);
		$resource_list->addResource(
			'Arguments',
			'GetRequest',
			$this->_get_request
		);

		try
		{
			$controller->processPreAction();
		}
		catch(Mephex_App_Resource_Exception_UnknownLoader $ex)
		{
			$this->assertEquals(
				'PostRequest',
				$ex->getResourceName()
			);
		}
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::processPreAction
	 * @covers Mephex_Controller_Action_Http::getGetRequest
	 */
	public function testGetRequestIsMadeAvailableAfterPreAction()
	{
		$this->assertNull($this->_controller->getGetRequest());
		$this->_controller->processPreAction();

		$args	= $this->_controller->getGetRequest();
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('GET', $args->get('unitTesting'));
	}



	/**
	 * @covers Mephex_Controller_Action_Http::processPreAction
	 */
	public function testGetRequestResourceTypeIsCheckedByPreAction()
	{
		$resource_list	= new Mephex_App_Resource_List();
		$resource_list->addType('Arguments', 'Mephex_App_Arguments');
		$controller		= new Stub_Mephex_Controller_Action_Http(
			$resource_list
		);
		$resource_list->addResource(
			'Arguments',
			'HttpConnectionInfo',
			$this->_http_info
		);
		$resource_list->addResource(
			'Arguments',
			'PostRequest',
			$this->_post_request
		);

		try
		{
			$controller->processPreAction();
		}
		catch(Mephex_App_Resource_Exception_UnknownLoader $ex)
		{
			$this->assertEquals(
				'GetRequest',
				$ex->getResourceName()
			);
		}
	}
}