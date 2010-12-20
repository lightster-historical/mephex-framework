<?php



/**
 * Writer stream that writes a raw record using a table schema (table name,
 * field names, and sequential identifier field name).
 * 
 * @author mlight
 */
abstract class Mephex_Model_Stream_Writer_Database_SequentialId
extends Mephex_Model_Stream_Writer_Database_InsertUpdate
{
	/**
	 * Getter for the table name.
	 * 
	 * @return string
	 */
	protected abstract function getStorageTable();
	
	/**
	 * Getter for the array of field names (not including the sequential id field).
	 * 
	 * @return array
	 */
	protected abstract function getStorageFields();
	
	/**
	 * The name of the sequential id field.
	 * 
	 * @return string
	 */
	protected abstract function getStorageSequentialIdField();
	
	
	
	/**
	 * Generates the default insert generator.
	 * 
	 * @return Mephex_Db_Sql_Base_Generator_Insert
	 */
	protected function getDefaultInsertGenerator()
	{
		return $this->getConnection()->generateInsert(
			$this->getStorageTable(), 
			$this->getStorageFields()
		);
	}
	
	
	
	/**
	 * Generates the default update generator.
	 * 
	 * @return Mephex_Db_Sql_Base_Generator_Update
	 */
	protected function getDefaultUpdateGenerator()
	{
		return $this->getConnection()->generateUpdate(
			$this->getStorageTable(), 
			$this->getStorageFields(),
			array($this->getStorageSequentialIdField())
		);
	}
}  