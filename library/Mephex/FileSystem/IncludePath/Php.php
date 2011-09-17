<?php



/**
 * Checks for existence and determines paths of files relative to
 * the PHP include path.
 * 
 * @author mlight
 */
class Mephex_FileSystem_IncludePath_Php
extends Mephex_FileSystem_IncludePath
{
	public function __construct()
	{
		parent::__construct(get_include_path());
	}



	/**
	 * Reset the include paths to match PHP's current include_path value.
	 * 
	 * @return void
	 */
	public function resetIncludePaths()
	{
		$this->setIncludePaths(get_include_path());
	}
}