<?php



class Mephex_Controller_ActionTest
extends Mephex_Test_TestCase
{
	protected $_controller;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_controller	= new Stub_Mephex_Controller_Action();
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Action
	 */
	public function testActionControllerIsImplementable()
	{
		$this->assertTrue($this->_controller instanceof Mephex_Controller_Action);
	}
}