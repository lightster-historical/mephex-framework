<?php



class Mephex_App_BootstrapTest
extends Mephex_Test_TestCase
{
	protected $_bootstrap;

	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_bootstrap	= new Stub_Mephex_App_Bootstrap();
	}

	
	
	public function testAbstractBootstrapCanBeExtended()
	{
		$this->assertTrue(
			$this->_bootstrap instanceof Mephex_App_Bootstrap
		);
	}
}