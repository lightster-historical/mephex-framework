<?php



class Mephex_Test_TmpFileCopierTest
extends Mephex_Test_TestCase
{
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testCopierWithUnwritableTemporaryDirectoryThrowsAnException()
	{
		$copier	= $this->getTmpCopier('tmp' . DIRECTORY_SEPARATOR . 'unwritable');
	}
	
	
	
	public function testTemporaryCopyCanBeCreated()
	{
		$file		= PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php';
		$tmp_file	= $this->getTmpCopier()->copy($file);
		$this->assertTrue(file_exists($tmp_file));
	}
	
	
	
	public function testTemporaryCopyIsDeleted()
	{
		$file		= PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php';
		$tmp_file	= $this->getTmpCopier()->copy($file);
		$this->assertTrue(file_exists($tmp_file));
		
		$this->_copier	= null;
		
		$this->assertFalse(file_exists($tmp_file));
	}
	
	
	
	public function testTemporaryCopiesAreDeleted()
	{
		$files		= array(
			PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php',
			PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'phpunit.xml'
		);
		$tmp_files	= array();
		
		foreach($files as $file)
		{
			$tmp_files[] = $this->getTmpCopier()->copy($file);
		}
		
		foreach($tmp_files as $tmp_file)
		{
			$this->assertTrue(file_exists($tmp_file), "'{$tmp_file}' does not exist");
		}
		
		$this->_copier	= null;
	
		foreach($tmp_files as $tmp_file)
		{
			$this->assertFalse(file_exists($tmp_file), "'{$tmp_file}' was not deleted");
		}
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testCopyingUnreadableFileThrowsAnException()
	{
		$this->getTmpCopier()->copy(PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'non-existent.txt');
	}
}  