<?php



class Mephex_Model_Stream_Writer_Database_SequentialIdTest
extends Mephex_Test_TestCase
{
	protected $_db;
	protected $_writer;
	
	
	
	public function tearDown()
	{
		$this->_db			= null;
		$this->_writer		= null;
	}
	
	
	
	protected function getWriter()
	{
		if($this->_writer === null)
		{
			$this->_db	= $this->getSqliteConnection('dbs/basic.sqlite3');
			$this->_db->write('DELETE FROM multi_col')->execute();
			
			$this->_writer	= new Stub_Mephex_Model_Stream_Writer_Database_SequentialId(
				$this->_db
			);
		}
		
		return $this->_writer;
	}
	
	
	
	public function testInsertGeneratorIsLazyLoaded()
	{
		$gen1	= $this->getWriter()->getInsertGenerator();
		$gen2	= $this->getWriter()->getInsertGenerator();
		
		$this->assertTrue($gen1 instanceof Mephex_Db_Sql_Base_Generator_Insert);
		$this->assertTrue($gen1 === $gen2);
	}
	
	
	
	public function testInsertQueryIsLazyLoaded()
	{
		$query1	= $this->getWriter()->getInsertQuery();
		$query2	= $this->getWriter()->getInsertQuery();
		
		$this->assertTrue($query1 instanceof Mephex_Db_Sql_Base_Query);
		$this->assertTrue($query1 === $query2);
	}
	
	
	
	public function testUpdateGeneratorIsLazyLoaded()
	{
		$gen1	= $this->getWriter()->getUpdateGenerator();
		$gen2	= $this->getWriter()->getUpdateGenerator();
		
		$this->assertTrue($gen1 instanceof Mephex_Db_Sql_Base_Generator_Update);
		$this->assertTrue($gen1 === $gen2);
	}
	
	
	
	public function testUpdateQueryIsLazyLoaded()
	{
		$query1	= $this->getWriter()->getUpdateQuery();
		$query2	= $this->getWriter()->getUpdateQuery();
		
		$this->assertTrue($query1 instanceof Mephex_Db_Sql_Base_Query);
		$this->assertTrue($query1 === $query2);
	}
	
	
	
	public function testRecordCanBeInserted()
	{
		$data	= array
		(
			'title'			=> 'Some Title',
			'description'	=> 'A lengthier description',
			'sort_order'	=> '24',
			'other'			=> 'What goes here?'
		);
		
		$this->getWriter()->create($data);
		
		$conn	= $this->_db;
		$results	= $conn->read('
			SELECT 
				title,
				description,
				sort_order,
				other
			FROM multi_col
		')->execute();
		$first_result	= true;
		foreach($results as $result)
		{
			$this->assertTrue($first_result);
			$first_result	= false;
			
			$this->assertEquals($result, $data);
			$this->assertTrue($result === $data);
		}
	}
	
	
	
	public function testRecordCanBeUpdated()
	{
		$data	= array
		(
			'title'			=> 'Some Title',
			'description'	=> 'A lengthier description',
			'sort_order'	=> '25',
			'other'			=> 'What goes here?'
		);
		$this->getWriter()->create($data);
		
		$conn	= $this->_db;
		$results	= $conn->read('
			SELECT 
				id,
				title,
				description,
				sort_order,
				other
			FROM multi_col
		')->execute();
		$has_result	= false;
		foreach($results as $updated_data)
		{
			$has_result	= true;
			break;
		}
		
		$this->assertTrue($has_result);
		
		$updated_data['title']			= 'New Title';
		$updated_data['description']	= 'New Description';
		$updated_data['sort_order']		= 25;
		$updated_data['other']			= 'Oh!';
		$this->getWriter()->update($updated_data);
		
		$conn	= $this->_db;
		$results	= $conn->read('
			SELECT 
				title,
				description,
				sort_order,
				other
			FROM multi_col
			WHERE id = ?
		')->execute(array($updated_data['id']));
		$first_result	= true;
		foreach($results as $result)
		{
			$this->assertTrue($first_result);
			$first_result	= false;
			
			$this->assertEquals($result, $updated_data);
			$this->assertTrue($result === $updated_data);
		}
	}
}  