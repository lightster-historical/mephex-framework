<?php



class Mephex_Db_Sql_Base_ResultSetTest
extends Mephex_Test_TestCase
{	
	protected $_result_set;
	
	
	
	public function setUp()
	{
		$this->_result_set	= new Stub_Mephex_Db_Sql_Base_ResultSet();
	}
	
	
	
	public function testResultSetIsIterator()
	{
		$this->assertTrue($this->_result_set instanceof Iterator);
	}
	
	

	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAResultSetDoesNotSupportLastInsertIdsByDefault()
	{
		$this->_result_set->getLastInsertId();
	}
}  