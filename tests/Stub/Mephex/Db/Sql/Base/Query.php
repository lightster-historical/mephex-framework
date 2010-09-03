<?php



class Stub_Mephex_Db_Sql_Base_Query
extends Mephex_Db_Sql_Base_Query
{
	public function getConnection()	{return parent::getConnection();}
	
	protected function executeNativePrepare(array & $params)	{return self::PREPARE_NATIVE;}
	protected function executeEmulatedPrepare(array & $params)	{return self::PREPARE_EMULATED;}
	protected function executeNonPrepare(array & $params)		{return self::PREPARE_OFF;}
}