<?php



/**
 * Abstract class loader.
 * 
 * @author mlight
 */
abstract class Mephex_App_ClassLoader
{
	/**
	 * Loads the class of the given name.
	 * 
	 * @param string $class_name
	 * @return bool
	 */
	public abstract function loadClass($class_name);
	
	
	
	/**
	 * Determines if a readable path/file exists in the include path.
	 * 
	 * @param string $path
	 * @return bool
	 */
	protected function includeExists($path)
	{
		if(substr($path, 0, 1) === '/')
		{
			return is_readable($path);
		}
		else
		{
	        $include_paths	= explode(PATH_SEPARATOR, get_include_path());
	        foreach($include_paths as $include_path)
	        {
				if(is_readable($include_path . '/' . $path))
				{
					return true;
				}
	        }
		}
	        
        return false;
	}
}