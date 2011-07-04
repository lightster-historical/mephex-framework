<?php



class Stub_Mephex_FileSystem_IncludePath
extends Mephex_FileSystem_IncludePath
{
	public function parsePaths(array $paths)
		{return parent::parsePaths($paths);}
	public function isAbsolutePath($path)
		{return parent::isAbsolutePath($path);}
	public function checkFileExistence($path)
		{return parent::checkFileExistence($path);}
}