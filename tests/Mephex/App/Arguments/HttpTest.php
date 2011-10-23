<?php



class Mephex_App_Arguments_HttpTest
extends Mephex_Test_TestCase
{
	protected $_http_info;
	protected $_post_request;
	protected $_get_request;
	protected $_other_args;

	protected $_arguments;
	
	
	
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
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_Http::__construct
	 */
	public function testHttpArgumentsExtendsArguments()
	{
		$this->assertTrue($this->_arguments instanceof Mephex_App_Arguments);
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_Http::getHttpConnectionInfo
	 */
	public function testHttpConnectionInfoIsAvailable()
	{
		$args	= $this->_arguments->getHttpConnectionInfo();
		
		$this->assertTrue($args instanceof Mephex_App_Arguments_HttpConnection);
		$this->assertEquals('SERVER', $args->get('unitTesting'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_Http::getPostRequest
	 */
	public function testPostRequestIsAvailable()
	{
		$args	= $this->_arguments->getPostRequest();
		 
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('POST', $args->get('unitTesting'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_Http::getGetRequest
	 */
	public function testGetRequestIsAvailable()
	{
		$args	= $this->_arguments->getGetRequest();
		 
		$this->assertTrue($args instanceof Mephex_App_Arguments);
		$this->assertEquals('GET', $args->get('unitTesting'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_Http::__construct
	 */
	public function testOtherArgumentsCanBeSet()
	{
		$this->assertEquals('other', $this->_arguments->get('unitTesting'));
	}
}