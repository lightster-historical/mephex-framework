<?php



/**
 * Checks for existence and determines paths of files relative to
 * an include path.
 * 
 * @author mlight
 */
class Mephex_FileSystem_IncludePath
{
	/**
	 * An array of paths to check for the include.
	 * 
	 * @var array
	 */
	protected $_include_paths;
	
	
	
	/**
	 * @param array/string $include_paths - an array/string of
	 * 		paths to check for the include
	 */
	public function __construct($include_paths = array())
	{
		$this->setIncludePaths($include_paths);
	}
	
	
	
	/**
	 * Parses the array of paths and separates any composite paths.
	 * 
	 * @param array $paths - array of simple and/or composite paths
	 * @return array
	 */
	protected function parsePaths(array $paths)
	{
		$parsed_paths	= array();
		foreach($paths as $path)
		{
			$parsed_paths	= array_merge(
				$parsed_paths,
				explode(PATH_SEPARATOR, $path)
			);
		}
		
		return $parsed_paths;
	}



	/**
	 * Setter for include paths.
	 *
	 * @param array/string $include_paths - an array/string of paths
	 *		to check for the include
	 * @return void
	 */
	public function setIncludePaths($include_paths)
	{
		if(!$include_paths) {
			$include_paths	= array();
		}

		$this->_include_paths	= $this->parsePaths(
			is_array($include_paths)
			? $include_paths
			: array($include_paths)
		);
	}
	
	
	
	/**
	 * Getter for include paths.
	 * 
	 * @return array
	 */
	public function getIncludePaths()
	{
		return $this->_include_paths;
	}
	
	
	
	/**
	 * Finds the first path to the include of the given path.
	 * 
	 * @param string $path - the include to look for
	 * @return string
	 */
	public function find($path)
	{
		if($this->isAbsolutePath($path))
		{
			return (is_readable($path) ? $path : null);
		}
		
		foreach($this->getIncludePaths() as $include_path)
		{
			$full_path	= $include_path . '/' . $path;
			
			if($this->checkFileExistence($full_path))
			{
				return $full_path;
			}
		}
		
		return null;
	}
	
	
	
	/**
	 * Finds all paths to the include of the given path.
	 * 
	 * @param string $path - the include to look for
	 * @return string
	 */
	public function findAll($path)
	{
		if($this->isAbsolutePath($path))
		{
			return (is_readable($path) ? array($path) : array());
		}

		$all	= array();
		foreach($this->getIncludePaths() as $include_path)
		{
			$full_path	= $include_path . '/' . $path;
			
			if($this->checkFileExistence($full_path))
			{
				$all[]	= $full_path;
			}
		}
		
		return $all;
	}
	
	
	
	/**
	 * Checks to see if the given include can be found at all.
	 * 
	 * @param string $path - the include to look for
	 * @return bool
	 */
	public function checkExistence($path)
	{
		return (null !== $this->find($path));
	}
	
	
	
	/**
	 * Determines if the given path is an absolute path.
	 * 
	 * @param string $path - the path to check
	 * @return bool
	 */
	protected function isAbsolutePath($path)
	{
		return (substr($path, 0, 1) === '/');
	}
	
	
	
	/**
	 * Checks for the existence of a file.
	 * 
	 * @param string $path - the path of the file to check existence for
	 * @return bool
	 */
	protected function checkFileExistence($path)
	{
		return file_exists($path);
	}
}