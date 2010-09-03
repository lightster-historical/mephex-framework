<?php



/**
 * A temporary file copier. Copies files to a temporary directory
 * and deletes the files upon object destruction.
 * 
 * @author mlight
 */
class Mephex_Test_TmpFileCopier
{
	/**
	 * The temporary directory.
	 * 
	 * @var string
	 */
	protected $_tmp_dir;
	
	/**
	 * An array of temporary files => original files copied by this
	 * file.
	 * 
	 * @var array
	 */
	protected $_files;
	
	
	
	/**
	 * @param string $tmp_dir - the directory to store the temporary files.
	 */
	public function __construct($tmp_dir)
	{
		if(!is_writable($tmp_dir))
		{
			throw new Mephex_Exception("Temporary directory '{$tmp_dir}' is not writable.");
		}
		
		$this->_files	= array();
		$this->_tmp_dir	= $tmp_dir;
	}
	
	
	
	/**
	 * Destroys all temporary files.
	 */
	public function __destruct()
	{
		foreach($this->_files as $tmp => $src)
		{
			unlink($tmp);
		}
	}
	
	
	
	/**
	 * Copies a file to the temporary directory using a random 
	 * destination file name. The destination file's path is returned.
	 * 
	 * @param string $file - the original file
	 * @return string - the destination file name
	 */
	public function copy($file)
	{
		$tmp_file	= $this->_tmp_dir . DIRECTORY_SEPARATOR 
			. uniqid() . '_' . basename($file);

		if(is_readable($file) && copy($file, $tmp_file))
		{
			$this->_files[$tmp_file] = $file;
			return $tmp_file;
		}
		
		throw new Mephex_Exception("Cannot copy '{$file}'.");
	}
}