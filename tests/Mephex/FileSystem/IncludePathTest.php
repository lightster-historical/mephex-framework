<?php



class Mephex_FileSystem_IncludePathTest
extends Mephex_Test_TestCase
{
	protected $_include_path;
	
	
	
	public function setUp()
	{
		$this->_include_path	= new Stub_Mephex_FileSystem_IncludePath(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1',
				'./Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3'
			)
		);
	} 
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::parsePaths
	 */
	public function testPathIsProperlyParsed()
	{
		$paths	= array(
			'./Mephex/FileSystem/includePathFileSystem/set1'
				. PATH_SEPARATOR
				. './Mephex/FileSystem/includePathFileSystem/set2',
			'./Mephex/FileSystem/includePathFileSystem/set3'
		);
		
		$parsed	= $this->_include_path->parsePaths(array(implode(PATH_SEPARATOR, $paths)));
		
		$this->assertEquals(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1',
				'./Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3',
			),
			$parsed
		);
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::getIncludePaths
	 * @covers Mephex_FileSystem_IncludePath::setIncludePaths
	 */
	public function testArrayOfIncludePathsCanBeSet()
	{
		$this->_include_path->setIncludePaths(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1'
					. PATH_SEPARATOR
					. './Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3'
			)
		);
		
		$this->assertEquals(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1',
				'./Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3',
			),
			$this->_include_path->getIncludePaths()
		);
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::getIncludePaths
	 * @covers Mephex_FileSystem_IncludePath::setIncludePaths
	 */
	public function testStringOfIncludePathsCanBeSet()
	{
		$this->_include_path->setIncludePaths(
			'./Mephex/FileSystem/includePathFileSystem/set1'
				. PATH_SEPARATOR
				. './Mephex/FileSystem/includePathFileSystem/set2'
				. PATH_SEPARATOR
				. './Mephex/FileSystem/includePathFileSystem/set3'
		);
		
		$this->assertEquals(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1',
				'./Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3',
			),
			$this->_include_path->getIncludePaths()
		);
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::getIncludePaths
	 * @covers Mephex_FileSystem_IncludePath::setIncludePaths
	 */
	public function testEmptyIncludePathsCanBeSet()
	{
		$this->_include_path->setIncludePaths(NULL);
		
		$this->assertEquals(array(), $this->_include_path->getIncludePaths());
	}



	/**
	 * @covers Mephex_FileSystem_IncludePath::__construct
	 */
	public function testPathsPassedToConstructorAreUsedAsIncludePaths()
	{
		$paths	= array(
			'./Mephex/FileSystem/includePathFileSystem/set1a',
			'./Mephex/FileSystem/includePathFileSystem/set2b',
			'./Mephex/FileSystem/includePathFileSystem/set3c'
		);
		$include_path	= new Stub_Mephex_FileSystem_IncludePath($paths);

		$this->assertEquals($paths, $include_path->getIncludePaths());
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::isAbsolutePath
	 */
	public function testAbsolutePathCanBeProperlyDetected()
	{
		$this->assertTrue($this->_include_path->isAbsolutePath('/usr/bin/php'));
		$this->assertTrue($this->_include_path->isAbsolutePath('/home/mlight/error_log'));
		
		$this->assertFalse($this->_include_path->isAbsolutePath('php'));
		$this->assertFalse($this->_include_path->isAbsolutePath('error_log'));
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::checkFileExistence
	 */
	public function testFileExistenceCanBeDetected()
	{
		$this->assertTrue($this->_include_path->checkFileExistence(__FILE__));
		$this->assertFalse($this->_include_path->checkFileExistence('this_file_is_missing'));
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::checkExistence
	 */
	public function testIncludeExistenceCanBeDetected()
	{
		$this->assertTrue($this->_include_path->checkExistence(__FILE__));
		$this->assertTrue($this->_include_path->checkExistence('1.txt'));
		$this->assertTrue($this->_include_path->checkExistence('2.txt'));
		$this->assertTrue($this->_include_path->checkExistence('3.txt'));
		$this->assertTrue($this->_include_path->checkExistence('1and2.txt'));
		$this->assertTrue($this->_include_path->checkExistence('1and3.txt'));
		$this->assertTrue($this->_include_path->checkExistence('2and3.txt'));
		$this->assertTrue($this->_include_path->checkExistence('all.txt'));

		$this->assertFalse($this->_include_path->checkExistence('missing.txt'));
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::find
	 */
	public function testPathToAbsoluteIncludesAreFound()
	{
		$this->assertEquals(__FILE__, $this->_include_path->find(__FILE__));
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::find
	 */
	public function testPathToRelativeIncludesAreFound()
	{
		$test_cases	= array(
			'1.txt'		=> './Mephex/FileSystem/includePathFileSystem/set1/1.txt',
			'2.txt'		=> './Mephex/FileSystem/includePathFileSystem/set2/2.txt',
			'3.txt'		=> './Mephex/FileSystem/includePathFileSystem/set3/3.txt',
			'1and2.txt'	=> './Mephex/FileSystem/includePathFileSystem/set1/1and2.txt',
			'1and3.txt'	=> './Mephex/FileSystem/includePathFileSystem/set1/1and3.txt',
			'2and3.txt'	=> './Mephex/FileSystem/includePathFileSystem/set2/2and3.txt',
			'all.txt'	=> './Mephex/FileSystem/includePathFileSystem/set1/all.txt',
		);
		foreach($test_cases as $include => $expected)
		{
			$this->assertEquals($expected, $this->_include_path->find($include));
		}
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::find
	 */
	public function testPathToMissingIncludeIsNull()
	{
		$this->assertNull($this->_include_path->find('missing.txt'));
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::findAll
	 */
	public function testAllPathsToAbsoluteIncludesAreFound()
	{
		$this->assertEquals(array(__FILE__), $this->_include_path->findAll(__FILE__));
	}
	
	

	/**
	 * @covers Mephex_FileSystem_IncludePath::findAll
	 */
	public function testAllPathsToRelativeIncludesAreFound()
	{
		$test_cases	= array(
			'1.txt'		=> array(
				'./Mephex/FileSystem/includePathFileSystem/set1/1.txt'
			),
			'2.txt'		=> array(
				'./Mephex/FileSystem/includePathFileSystem/set2/2.txt'
			),
			'3.txt'		=> array(
				'./Mephex/FileSystem/includePathFileSystem/set3/3.txt'
			),
			'1and2.txt'	=> array(
				'./Mephex/FileSystem/includePathFileSystem/set1/1and2.txt',
				'./Mephex/FileSystem/includePathFileSystem/set2/1and2.txt'
			),
			'1and3.txt'	=> array(
				'./Mephex/FileSystem/includePathFileSystem/set1/1and3.txt',
				'./Mephex/FileSystem/includePathFileSystem/set3/1and3.txt'
			),
			'2and3.txt'	=> array(
				'./Mephex/FileSystem/includePathFileSystem/set2/2and3.txt',
				'./Mephex/FileSystem/includePathFileSystem/set3/2and3.txt'
			),
			'all.txt'	=> array(
				'./Mephex/FileSystem/includePathFileSystem/set1/all.txt',
				'./Mephex/FileSystem/includePathFileSystem/set2/all.txt',
				'./Mephex/FileSystem/includePathFileSystem/set3/all.txt'
			)
		);
		foreach($test_cases as $include => $expected)
		{
			$this->assertEquals($expected, $this->_include_path->findAll($include));
		}
	}
	
	
	
	/**
	 * @covers Mephex_FileSystem_IncludePath::findAll
	 */
	public function testAllPathsToMissingIncludeIsEmptyArray()
	{
		$this->assertTrue(array() === $this->_include_path->findAll('missing.txt'));
	}
}  