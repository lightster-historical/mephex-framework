<?php



class Stub_Mephex_Model_Stream_Writer_Database
extends Mephex_Model_Stream_Writer_Database
{
	public function getConnection()	
		{return parent::getConnection();}
	public function getTableSet()
		{return parent::getTableSet();}
	public function getTable($table)
		{return parent::getTable($table);}
	
	public function write($data) {}
}  