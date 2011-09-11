<?php



class Mephex_Controller_Action_HttpTest
extends Mephex_Test_TestCase
{
	protected $_controller;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$_SERVER['unitTesting']	= 'SERVER';
		$_POST['unitTesting']	= 'POST';
		$_GET['unitTesting']	= 'GET';
		
		$this->_controller	= new Stub_Mephex_Controller_Action_Http();
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::__construct
	 */
	public function testHttpControllerExtendsActionController()
	{
		$this->assertTrue($this->_controller instanceof Mephex_Controller_Action_Base);
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::getHttpConnectionInfo
	 */
	public function testHttpConnectionInfoIsAvailable()
	{
		$args	= $this->_controller->getHttpConnectionInfo();
		 
		$this->assertTrue($args instanceof Mephex_App_Arguments_HttpConnection);
		$this->assertEquals('SERVER', $args->get('unitTesting'));
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::getPostRequest
	 */
	public function testPostRequestIsAvailable()
	{
		$args	= $this->_controller->getPostRequest();
		 
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('POST', $args->get('unitTesting'));
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action_Http::getGetRequest
	 */
	public function testGetRequestIsAvailable()
	{
		$args	= $this->_controller->getGetRequest();
		 
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('GET', $args->get('unitTesting'));
	}
}