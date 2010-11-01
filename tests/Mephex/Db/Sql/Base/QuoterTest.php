<?php



class Mephex_Db_Sql_Base_QuoterTest
extends Mephex_Test_TestCase
{
	protected $_quoter	= null;
	
	
	
	protected function setUp()
	{	
		$this->_quoter	= new Mephex_Db_Sql_Base_Quoter();
	}
	
	
	
	public function testSqlBaseQuoterExtendsSqlQuoter()
	{
		$this->assertTrue($this->_quoter instanceof Mephex_Db_Sql_Quoter);
	}
	
	
	
	public function testTableNamesAreProperlyQuoted()
	{
		$this->assertEquals(
			'`some"\'``_``\'table`',
			$this->_quoter->quoteTable('some"\'`_`\'table')
		);
	}
	
	
	
	public function testColumnNamesAreProperlyQuoted()
	{
		$this->assertEquals(
			'`some\'``_``\'"column`',
			$this->_quoter->quoteColumn('some\'`_`\'"column')
		);
	}
	
	
	
	public function testNullValuesAreProperlyQuoted()
	{
		$this->assertEquals(
			'null',
			$this->_quoter->quoteValue(null)
		);
	}
	
	
	
	public function testNumericValuesAreProperlyQuoted()
	{
		$this->assertEquals(123, $this->_quoter->quoteValue(123));
		$this->assertEquals(123, $this->_quoter->quoteValue('123'));
		$this->assertEquals(123.45, $this->_quoter->quoteValue(123.45));
		$this->assertEquals(123.45, $this->_quoter->quoteValue('123.45'));
		$this->assertEquals('\'123.45y\'', $this->_quoter->quoteValue('123.45y'));
	}
	
	
	
	public function testValuesAreProperlyQuoted()
	{
		$this->assertEquals(
			'\'some\\\'`\\"_`\\\'value\'',
			$this->_quoter->quoteValue('some\'`"_`\'value')
		);
	}
}