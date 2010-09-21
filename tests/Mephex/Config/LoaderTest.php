<?php



class Mephex_Config_LoaderTest
extends Mephex_Test_TestCase
{
	protected $_loader;
	
	
	
	public function setUp()
	{
		$this->_loader	= new Stub_Mephex_Config_Loader();
	} 
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_loader instanceof Mephex_Config_Loader);
	}
}  