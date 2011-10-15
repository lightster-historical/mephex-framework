<?php



class Mephex_App_Arguments_HttpConnectionTest
extends Mephex_Test_TestCase
{
	protected function setUp()
	{
		parent::setUp();
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_HttpConnection::__construct
	 */
	public function testDefaultArgumentsAreFromServerSuperGlobal()
	{
		$args	= new Mephex_App_Arguments_HttpConnection($_SERVER);
		
		$match	= true;
		foreach($_SERVER as $key => $val)
		{
			if($args->get($key) !== $val)
			{
				$match	= false;
			}
		}
		
		$this->assertTrue($match);
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_HttpConnection::isXmlHttpRequest
	 */
	public function testAbleToDetectXmlHttpRequests()
	{
		$args	= new Mephex_App_Arguments_HttpConnection(array('HTTP_X_REQUESTED_WITH' => 'XmlHttpRequest'));
		$this->assertTrue($args->isXmlHttpRequest());
		
		$args	= new Mephex_App_Arguments_HttpConnection(array('HTTP_X_REQUESTED_WITH' => 'SomethingElse'));
		$this->assertFalse($args->isXmlHttpRequest());
		
		$args	= new Mephex_App_Arguments_HttpConnection(array());
		$this->assertFalse($args->isXmlHttpRequest());
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments_HttpConnection::isNoCacheRequest
	 */
	public function testAbleToDetectNoCacheRequests()
	{
		$args	= new Mephex_App_Arguments_HttpConnection(array('HTTP_CACHE_CONTROL' => 'no-cache'));
		$this->assertTrue($args->isNoCacheRequest());
		
		$args	= new Mephex_App_Arguments_HttpConnection(array('HTTP_CACHE_CONTROL' => 'noncache'));
		$this->assertFalse($args->isNoCacheRequest());
		
		$args	= new Mephex_App_Arguments_HttpConnection(array());
		$this->assertFalse($args->isNoCacheRequest());
	}
}