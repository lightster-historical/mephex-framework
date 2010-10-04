<?php



class Mephex_Db_TableSetTest
extends Mephex_Test_TestCase
{
	protected $_table_set;
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_table_set	= new Mephex_Db_TableSet();
	}
	
	
	
	protected function tearDown()
	{
		parent::tearDown();
		
		$this->_table_set	= null;
	}
	
	
	
	public function testTablePrefixIsBlankByDefault()
	{
		$this->assertEquals('', $this->_table_set->getPrefix());
	}
	
	
	
	public function testTableSuffixIsBlankByDefault()
	{
		$this->assertEquals('', $this->_table_set->getSuffix());
	}
	
	
	
	public function testTablePrefixAndSuffixCanBePassedToConstructor()
	{
		$this->_table_set	= new Mephex_Db_TableSet('SomePrefix', 'SomeSuffix');
		
		$this->assertEquals('SomePrefix', $this->_table_set->getPrefix());
		$this->assertEquals('SomeSuffix', $this->_table_set->getSuffix());
	}
	
	
	
	public function testTablePrefixCanBeChanged()
	{
		$this->_table_set->setPrefix('NewPrefix');
		$this->assertEquals('NewPrefix', $this->_table_set->getPrefix());
	}
	
	
	
	public function testTableSuffixCanBeChanged()
	{
		$this->_table_set->setSuffix('NewSuffix');
		$this->assertEquals('NewSuffix', $this->_table_set->getSuffix());
	}
	
	
	
	public function testTableNamesAreCached()
	{
		$this->assertEquals('table', $this->_table_set->get('table'));
		
		$this->_table_set->setPrefix('NewPrefix');
		$this->_table_set->setSuffix('NewSuffix');
		
		$this->assertEquals('table', $this->_table_set->get('table'));
	}
	
	
	
	public function testTableNamesCanBeOverriden()
	{
		$this->_table_set->setPrefix('NewPrefix');
		$this->_table_set->setSuffix('NewSuffix');
		$this->_table_set->set('table', 'quack');
		
		$this->assertEquals('quack', $this->_table_set->get('table'));
	}
}  