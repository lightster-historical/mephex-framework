<?php



class Mephex_Config_Loader_IniTest
extends Mephex_Test_TestCase
{
	protected $_option_set;
	
	
	
	public function setUp()
	{
		$this->_option_set	= new Stub_Mephex_Config_OptionSet(false);
	}
	
	
	
	public function getIniLoader($file_name)
	{
		return new Mephex_Config_Loader_Ini($file_name);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testMissingIniThrowsException()
	{
		$this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/missing.ini')
		)->loadOption($this->_option_set, 'some_group', 'some_option');
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testInaccessibleIniThrowsException()
	{
		$this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/')
		)->loadOption($this->_option_set, 'some_group', 'some_option');
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testInvalidIniThrowsException()
	{
		$this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/invalid.ini')
		)->loadOption($this->_option_set, 'some_group', 'some_option');
	}
	
	
	
	public function testIniOptionsCanBeProperlyLoaded()
	{
		$this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/simple.ini')
		)->loadOption($this->_option_set, 'some_group', 'some_option');

		$this->assertEquals('some_value', $this->_option_set->get('default', 'some_option'));
		$this->assertEquals('some.value', $this->_option_set->get('default', 'some.option'));
		$this->assertEquals('some_group_value', $this->_option_set->get('group', 'some_option'));
		$this->assertEquals('some.group.value', $this->_option_set->get('group', 'some.option'));
	}
}