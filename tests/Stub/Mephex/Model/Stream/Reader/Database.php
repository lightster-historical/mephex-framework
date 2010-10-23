<?php



class Stub_Mephex_Model_Stream_Reader_Database
extends Mephex_Model_Stream_Reader_Database
{
	public function getConnection()	
		{return parent::getConnection();}
	public function getTableSet()
		{return parent::getTableSet();}
	public function getTable($table)
		{return parent::getTable($table);}
	
	public function read(Mephex_Model_Criteria $criteria) {}
}  