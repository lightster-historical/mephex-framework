<?php



class Mephex_Controller_Action_HttpTest
extends Mephex_Test_TestCase
{
	protected $_http_info;
	protected $_post_request;
	protected $_get_request;
	protected $_other_args;
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
		$this->_other_args		= array(
			'unitTesting'	=> 'other'
		);
		
		$this->_arguments	= new Mephex_App_Arguments_Http(
			$this->_http_info,
			$this->_post_request,
			$this->_get_request,
			$this->_other_args
		);

		$this->_front_ctrl	= new Stub_Mephex_Controller_Front_Base(
			$this->_arguments,
			'Stub_Mephex_Controller_Action_Base',
			'index'
		);
		$this->_controller	= new Stub_Mephex_Controller_Action_Http(
			$this->_front_ctrl
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
	 * @covers Mephex_Controller_Action_Http::getExpectedArgumentsClass
	 */
	public function testExpectedArgumentsClassIsHttpArgumentsClass()
	{
		$this->assertEquals(
			'Mephex_App_Arguments_Http',
			$this->_controller->getExpectedArgumentsClass()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::checkArguments
	 * @covers Mephex_Controller_Action_Http::getHttpConnectionInfo
	 */
	public function testHttpConnectionInfoIsMadeAvailableAfterCheckingArguments()
	{
		$this->assertNull($this->_controller->getHttpConnectionInfo());
		$this->_controller->checkArguments($this->_arguments);

		$args	= $this->_controller->getHttpConnectionInfo();
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('SERVER', $args->get('unitTesting'));
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::checkArguments
	 * @covers Mephex_Controller_Action_Http::getPostRequest
	 */
	public function testPostRequestIsMadeAvailableAfterCheckingArguments()
	{
		$this->assertNull($this->_controller->getPostRequest());
		$this->_controller->checkArguments($this->_arguments);

		$args	= $this->_controller->getPostRequest();
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('POST', $args->get('unitTesting'));
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::checkArguments
	 * @covers Mephex_Controller_Action_Http::getGetRequest
	 */
	public function testGetRequestIsMadeAvailableAfterCheckingArguments()
	{
		$this->assertNull($this->_controller->getGetRequest());
		$this->_controller->checkArguments($this->_arguments);

		$args	= $this->_controller->getGetRequest();
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('GET', $args->get('unitTesting'));
	}
}