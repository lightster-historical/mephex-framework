<?php



class Mephex_Controller_FrontTest
extends Mephex_Test_TestCase
{
	protected $_front_ctrl;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_front_ctrl	= new Stub_Mephex_Controller_Front();
	}
	
	
	
	/**
	 * @covers Mephex_Controller_Front
	 */
	public function testFrontControllerIsImplementable()
	{
		$this->assertTrue($this->_front_ctrl instanceof Mephex_Controller_Front);
	}
}