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
		return new Stub_Mephex_Config_Loader_Ini($file_name);
	}
	
	
	
	/**
	 * @covers Mephex_Config_Loader_Ini::__construct
	 * @covers Mephex_Config_Loader_Ini::readFile
	 * @expectedException Mephex_Exception
	 */
	public function testMissingIniThrowsException()
	{
		$this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/missing.ini')
		)->readFile();
	}
	
	
	
	/**
	 * @covers Mephex_Config_Loader_Ini::__construct
	 * @covers Mephex_Config_Loader_Ini::readFile
	 * @expectedException Mephex_Exception
	 */
	public function testInaccessibleIniThrowsException()
	{
		$this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/')
		)->readFile();
	}
	
	
	
	/**
	 * @covers Mephex_Config_Loader_Ini::__construct
	 * @covers Mephex_Config_Loader_Ini::readFile
	 * @expectedException Mephex_Exception
	 */
	public function testInvalidIniThrowsException()
	{
		$this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/invalid.ini')
		)->readFile();
	}



	/**
	 * @covers Mephex_Config_Loader_Ini::__construct
	 * @covers Mephex_Config_Loader_Ini::readFile
	 * @covers Mephex_Config_Loader_Ini::getOptions
	 */
	public function testOptionsCanBeRead()
	{
		$loader	= $this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/simple.ini')
		);
		$this->assertTrue(is_array($loader->getOptions()));
	}



	/**
	 * @covers Mephex_Config_Loader_Ini::__construct
	 * @covers Mephex_Config_Loader_Ini::readFile
	 * @covers Mephex_Config_Loader_Ini::getOptions
	 */
	public function testOptionsAreLazyLoaded()
	{
		$loader	= $this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/simple.ini')
		);
		$this->assertTrue($loader->getOptions() === $loader->getOptions());
	}
	
	
	
	/**
	 * @covers Mephex_Config_Loader_Ini::__construct
	 * @covers Mephex_Config_Loader_Ini::loadOption
	 */
	public function testIniOptionsCanLoadRequestedOption()
	{
		$loader	= $this->getIniLoader(PATH_TEST_ROOT
			. str_replace('/', DIRECTORY_SEPARATOR, '/Mephex/Config/Loader/ini/simple.ini')
		);

		$loader->loadOption($this->_option_set, 'default', 'some_option');
		$loader->loadOption($this->_option_set, 'default', 'some.option');
		$loader->loadOption($this->_option_set, 'group', 'some_option');
		$loader->loadOption($this->_option_set, 'group', 'some.option');

		$this->assertEquals('some_value', $this->_option_set->get('default', 'some_option'));
		$this->assertEquals('some.value', $this->_option_set->get('default', 'some.option'));
		$this->assertEquals('some_group_value', $this->_option_set->get('group', 'some_option'));
		$this->assertEquals('some.group.value', $this->_option_set->get('group', 'some.option'));
	}
}