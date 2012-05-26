<?php



require_once 'Mephex/FileSystem/IncludePath.php';
require_once 'Mephex/FileSystem/IncludePath/Php.php';



/**
 * Abstract class loader.
 * 
 * @author mlight
 */
abstract class Mephex_App_Class_Loader
{
	/**
	 * The include path to use for finding classes
	 *
	 * @var Mephex_FileSystem_IncludePath
	 */
	protected $_include_path;



	/**
	 * @param Mephex_FileSystem_IncludePath $include_path - the include path
	 *		to use for finding classes
	 */
	public function __construct(Mephex_FileSystem_IncludePath $include_path = null)
	{
		if($include_path)
		{
			$this->_include_path	= $include_path;
		}
		else
		{
			$this->_include_path	= new Mephex_FileSystem_IncludePath_Php();
		}
	}
	
	
	
	/**
	 * Loads the class of the given name.
	 * 
	 * @param string $class_name
	 * @return bool
	 */
	public abstract function loadClass($class_name);



	public function getIncludePath()
	{
		return $this->_include_path;
	}
}