<?php



class Mephex_FileSystem_IncludePath_PhpTest
extends Mephex_Test_TestCase
{
	protected $_php_include_path;
	protected $_include_path;
	
	
	
	public function setUp()
	{
		$this->_php_include_path	= get_include_path();

		// Force the class to be loaded if it hasn't been yet.
		// the PHP include path is changed by this test case;
		// we will not be able to find the class after the 
		// PHP include path has been changed
		class_exists('Mephex_FileSystem_IncludePath_Php');
	} 



	public function tearDown()
	{
		set_include_path($this->_php_include_path);
	}
	
	
	
	/**
	 * @cover Mephex_FileSystem_IncludePath_Php#__construct
	 */
	public function testIncludePathMatchesPhpIncludePath()
	{
		$paths	= array(
			'abc/123',
			'def/456'
		);
		set_include_path(implode(PATH_SEPARATOR, $paths));

		$include_path		= new Mephex_FileSystem_IncludePath_Php();
		$this->assertEquals($paths, $include_path->getIncludePaths());
	}
	
	
	
	/**
	 * @cover Mephex_FileSystem_IncludePath_Php#resetIncludePaths
	 */
	public function testIncludePathsCanBeReset()
	{
		$paths	= array(
			'abc/123',
			'def/456'
		);
		set_include_path(implode(PATH_SEPARATOR, $paths));

		$include_path		= new Mephex_FileSystem_IncludePath_Php();
		$this->assertEquals($paths, $include_path->getIncludePaths());

		$new_paths	= array(
			'abc/123/xyz',
			'def/456/uvw'
		);
		$include_path->setIncludePaths($new_paths);
		$this->assertEquals($new_paths, $include_path->getIncludePaths());

		$include_path->resetIncludePaths();
		$this->assertEquals($paths, $include_path->getIncludePaths());
	}
}  