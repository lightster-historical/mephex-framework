<?php



class Stub_Mephex_Model_Stream_Writer_Database_InsertUpdate
extends Mephex_Model_Stream_Writer_Database_InsertUpdate
{	
	public function getInsertGenerator()
		{return parent::getInsertGenerator();}
	public function getInsertQuery()
		{return parent::getInsertQuery();}
	public function getUpdateGenerator()
		{return parent::getUpdateGenerator();}
	public function getUpdateQuery()
		{return parent::getUpdateQuery();}
	
	
	
	protected function getDefaultInsertGenerator()
	{
		return $this->getConnection()->generateInsert
		(
			'multi_col', 
			array
			(
				'title',
				'description',
				'sort_order',
				'other'
			)
		);	
	}
	
	
	
	protected function getDefaultUpdateGenerator()
	{
		return $this->getConnection()->generateUpdate
		(
			'multi_col', 
			array
			(
				'title',
				'description',
				'sort_order',
				'other'
			),
			array
			(
				'id'
			)
		);	
	}
	
	
	
	protected function isRecordNew($data)
	{
		return empty($data['id']) ? true : false;
	}
}  