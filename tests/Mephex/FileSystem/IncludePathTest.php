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
	
	
	
	public function testPathIsProperlyParsed()
	{
		$paths	= array(
			'./Mephex/FileSystem/includePathFileSystem/set1',
			'./Mephex/FileSystem/includePathFileSystem/set2',
			'./Mephex/FileSystem/includePathFileSystem/set3',
		);
		
		$parsed	= $this->_include_path->parsePaths(array(implode(PATH_SEPARATOR, $paths)));
		
		foreach($parsed as $key => $path)
		{
			$this->assertEquals($paths[$key], $path);
		}
	}
	
	
	
	public function testArrayOfIncludePathsAreParsedProperly()
	{
		$include_path	= new Stub_Mephex_FileSystem_IncludePath(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1'
					. PATH_SEPARATOR
					. './Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3'
			)
		);
		$parsed	= $include_path->getIncludePaths();
		
		$this->assertEquals(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1',
				'./Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3',
			),
			$parsed
		);
	}
	
	
	
	public function testStringOfIncludePathsAreParsedProperly()
	{
		$include_path	= new Stub_Mephex_FileSystem_IncludePath(
			'./Mephex/FileSystem/includePathFileSystem/set1'
				. PATH_SEPARATOR
				. './Mephex/FileSystem/includePathFileSystem/set2'
				. PATH_SEPARATOR
				. './Mephex/FileSystem/includePathFileSystem/set3'
		);
		$parsed	= $include_path->getIncludePaths();
		
		$this->assertEquals(
			array(
				'./Mephex/FileSystem/includePathFileSystem/set1',
				'./Mephex/FileSystem/includePathFileSystem/set2',
				'./Mephex/FileSystem/includePathFileSystem/set3',
			),
			$parsed
		);
	}
	
	
	
	public function testAbsolutePathCanBeProperlyDetected()
	{
		$this->assertTrue($this->_include_path->isAbsolutePath('/usr/bin/php'));
		$this->assertTrue($this->_include_path->isAbsolutePath('/home/mlight/error_log'));
		
		$this->assertFalse($this->_include_path->isAbsolutePath('php'));
		$this->assertFalse($this->_include_path->isAbsolutePath('error_log'));
	}
	
	
	
	public function testFileExistenceCanBeDetected()
	{
		$this->assertTrue($this->_include_path->checkFileExistence(__FILE__));
		$this->assertFalse($this->_include_path->checkFileExistence('this_file_is_missing'));
	}
	
	
	
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
	
	
	
	public function testPathToAbsoluteIncludesAreFound()
	{
		$this->assertEquals(__FILE__, $this->_include_path->find(__FILE__));
	}
	
	
	
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
	
	
	
	public function testPathToMissingIncludeIsNull()
	{
		$this->assertNull($this->_include_path->find('missing.txt'));
	}
	
	
	
	public function testAllPathsToAbsoluteIncludesAreFound()
	{
		$this->assertEquals(array(__FILE__), $this->_include_path->findAll(__FILE__));
	}
	
	
	
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
	
	
	
	public function testAllPathsToMissingIncludeIsEmptyArray()
	{
		$this->assertTrue(array() === $this->_include_path->findAll('missing.txt'));
	}
}  