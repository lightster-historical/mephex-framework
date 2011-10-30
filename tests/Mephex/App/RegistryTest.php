<?php



class Mephex_App_RegistryTest
extends Mephex_Test_TestCase
{
	protected $_args;

	protected $_registry;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_args		= new Mephex_App_Arguments();
		$this->_registry	= new Mephex_App_Registry($this->_args);
	}
	
	
	
	/**
	 * @covers Mephex_App_Registry::__construct
	 * @covers Mephex_App_Registry::getArguments
	 */
	public function testArgumentsReturnedAreSameAsPassedToConstructor()
	{
		$this->assertTrue($this->_args === $this->_registry->getArguments());
	}
}