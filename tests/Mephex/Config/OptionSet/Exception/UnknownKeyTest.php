<?php



class Mephex_Config_OptionSet_Exception_UnknownKeyTest
extends Mephex_Test_TestCase
{
	private $_option_set;
	private $_group;
	private $_option;

	private $_exception;



	public function setUp()
	{
		$this->_option_set	= new Mephex_Config_OptionSet();
		$this->_group		= 'some_config_group';
		$this->_option		= 'some_config_option';

		$this->_exception	= new Mephex_Config_OptionSet_Exception_UnknownKey(
			$this->_option_set,
			$this->_group,
			$this->_option
		);
	}



	/**
	 * @expectedException Mephex_Config_OptionSet_Exception_UnknownKey
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Config_OptionSet_Exception_UnknownKey::__construct 
	 * @covers Mephex_Config_OptionSet_Exception_UnknownKey::getConfigOptionSet 
	 */
	public function testConfigOptionSetCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_option_set,
			$this->_exception->getConfigOptionSet()
		);
	}



	/**
	 * @covers Mephex_Config_OptionSet_Exception_UnknownKey::__construct 
	 * @covers Mephex_Config_OptionSet_Exception_UnknownKey::getGroup 
	 */
	public function testGroupCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_group,
			$this->_exception->getGroup()
		);
	}



	/**
	 * @covers Mephex_Config_OptionSet_Exception_UnknownKey::__construct 
	 * @covers Mephex_Config_OptionSet_Exception_UnknownKey::getOption 
	 */
	public function testOptionCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_option,
			$this->_exception->getOption()
		);
	}
}