<?php



/**
 * Writer stream that writes a raw record using either the insert or update
 * query.
 * 
 * @author mlight
 */
abstract class Mephex_Model_Stream_Writer_Database_InsertUpdate
extends Mephex_Model_Stream_Writer_Database
{
	/**
	 * Lazy-loaded insert generator.
	 * 
	 * @var Mephex_Db_Sql_Base_Generator_Insert
	 */
	private $_generator_insert	= null;
	
	/**
	 * Lazy-loaded prepared query for inserting a record.
	 * 
	 * @var Mephex_Db_Base_Query
	 */
	private $_query_insert	= null;
	
	/**
	 * Lazy-loaded update generator.
	 * 
	 * @var Mephex_Db_Sql_Base_Generator_Update
	 */
	private $_generator_update	= null;
	
	/**
	 * Lazy-loaded prepared query for updating a record.
	 * 
	 * @var Mephex_Db_Base_Query
	 */
	private $_query_update	= null;
	
	
	
	/**
	 * Generates the default insert generator.
	 * 
	 * @return Mephex_Db_Sql_Base_Generator_Insert
	 */
	protected abstract function getDefaultInsertGenerator();
	
	/**
	 * Generates the default update generator.
	 * 
	 * @return Mephex_Db_Sql_Base_Generator_Update
	 */
	protected abstract function getDefaultUpdateGenerator();
	
	/**
	 * Determines whether or not the record is a new record.
	 * 
	 * @param $data
	 * @return bool
	 */
	protected abstract function isRecordNew($data);
	
	
	
	/**
	 * Lazy-loads an insert query generator.
	 *  
	 * @return Mephex_Db_Sql_Base_Generator_Insert
	 */
	protected function getInsertGenerator()
	{
		if(null === $this->_generator_insert)
		{
			$this->_generator_insert	= $this->getDefaultInsertGenerator();
		}
		
		return $this->_generator_insert;
	}
	
	
	
	/**
	 * Lazy-loads a prepared query for inserting a record.
	 * 
	 * @return Mephex_Db_Base_Query
	 */
	protected function getInsertQuery()
	{
		if(null === $this->_query_insert)
		{
			$this->_query_insert	= $this->getConnection()->write(
				$this->getInsertGenerator()->getSql(),
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE
			);
		}
		
		return $this->_query_insert;
	}
	
	
	
	/**
	 * Lazy-loads an update query generator.
	 *  
	 * @return Mephex_Db_Sql_Base_Generator_Update
	 */
	protected function getUpdateGenerator()
	{
		if(null === $this->_generator_update)
		{
			$this->_generator_update	= $this->getDefaultUpdateGenerator();
		}
		
		return $this->_generator_update;
	}
	
	
	
	/**
	 * Lazy-loads a prepared query for updating a record.
	 * 
	 * @return Mephex_Db_Base_Query
	 */
	protected function getUpdateQuery()
	{
		if(null === $this->_query_update)
		{
			$this->_query_update	= $this->getConnection()->write(
				$this->getUpdateGenerator()->getSql(),
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE
			);
		}
		
		return $this->_query_update;
	}
	
	
	
	/**
	 * Writes the given record.
	 * 
	 * @param $data
	 * @return bool 
	 */
	public function write($data)
	{
		if($this->isRecordNew($data))
		{
			$query		= $this->getInsertQuery();
			$generator	= $this->getInsertGenerator();
		}
		else
		{
			$query		= $this->getUpdateQuery();
			$generator	= $this->getUpdateGenerator();
		}
		
		return $query->execute($generator->getColumnOrderedValues($data, false));
	}
}  