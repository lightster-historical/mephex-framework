<?php



class Stub_Mephex_Model_Stream_Writer_Database_SequentialId
extends Mephex_Model_Stream_Writer_Database_SequentialId
{	
	public function getInsertGenerator()
		{return parent::getInsertGenerator();}
	public function getInsertQuery()
		{return parent::getInsertQuery();}
	public function getUpdateGenerator()
		{return parent::getUpdateGenerator();}
	public function getUpdateQuery()
		{return parent::getUpdateQuery();}
	public function getDefaultInsertGenerator()
		{return parent::getDefaultInsertGenerator();}
	public function getDefaultUpdateGenerator()
		{return parent::getDefaultUpdateGenerator();}

		
		
	protected function getStorageTable()
	{
		return $this->getTable('multi_col');
	}
	
	
	
	protected function getStorageFields()
	{
		return array
		(
			'title',
			'description',
			'sort_order',
			'other'
		);
	}
	
	
	
	protected function getStorageSequentialIdField()
	{
		return 'id';
	}
}  