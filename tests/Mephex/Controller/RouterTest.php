<?php



class Mephex_Controller_RouterTest
extends Mephex_Test_TestCase
{
	protected $_router;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_router	= new Stub_Mephex_Controller_Router('ctrl', 'action');
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Router
	 */
	public function testControllerRouterIsImplementable()
	{
		$this->assertTrue($this->_router instanceof Mephex_Controller_Router);
	}
}