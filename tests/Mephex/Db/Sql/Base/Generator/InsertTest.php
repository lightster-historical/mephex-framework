<?php



class Mephex_Db_Sql_Base_Generator_InsertTest
extends Mephex_Test_TestCase
{
	protected $_insert	= null;
	
	
	
	protected function tearDown()
	{	
		parent::tearDown();
		
		$this->_insert	= null;
	}
	
	
	
	public function getInsert($table, array $columns, $quoter = null)
	{
		if(null === $this->_insert)
		{
			if(null === $quoter)
			{
				$quoter	= new Mephex_Db_Sql_Base_Quoter_Mysql();
			}
			$this->_insert	= new Stub_Mephex_Db_Sql_Base_Generator_Insert($quoter, $table, $columns);
		}
		
		return $this->_insert;
	}
	
	
	
	public function testInsertGeneratorIsGenerator()
	{
		$this->assertTrue(
			$this->getInsert('test', array('a', 'b', 'c'))
			instanceof 
			Mephex_Db_Sql_Base_Generator
		);
	}
	
	
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAQuoterIsRequired()
	{
		$insert	= new Stub_Mephex_Db_Sql_Base_Generator_Insert('test', array('abc', 'def'));
	}
	
	
	
	public function testQuoterProvidedToTheConstructorIsUsedByInsert()
	{
		$quoter	= new Mephex_Db_Sql_Base_Quoter_Mysql();
		$insert	= $this->getInsert('test', array('abc', 'def'), $quoter);
		
		$this->assertTrue($insert->getQuoter() instanceof Mephex_Db_Sql_Quoter);
		$this->assertTrue($insert->getQuoter() === $quoter);
	}
	
	
	
	public function testParametersAreReturnedInCorrectOrderAndAreNotQuoted()
	{
		$insert	= $this->getInsert('test', array('a', 'b', 'c'));
		
		$params	= array
		(
			'c'	=> 'd',
			'a'	=> 'e',
			'b'	=> 'f'
		);
		$expected	= array('e', 'f', 'd');
		$ordered	= $insert->getColumnOrderedValues($params, false);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	public function testParametersAreReturnedInCorrectOrderAndAreQuoted()
	{
		$insert	= $this->getInsert('test', array('a', 'b', 'c'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $insert->getColumnOrderedValues($params, true);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAMissingParameterCausesAnExceptionToBeThrown()
	{
		$insert	= $this->getInsert('test', array('a', 'b', 'c', 'x'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $insert->getColumnOrderedValues($params, true);
	}
	
	
	
	public function testAPreparedInsertIsProperlyGenerated()
	{
		$insert	= $this->getInsert('test', array('a', 'b', 'c'));
		
		$this->assertEquals(1, 
			preg_match(
				'/^\s*INSERT\s+INTO\s+`test`\s+\(\s*`a`\s*,\s*`b`\s*,\s*`c`\s*\)\s+VALUES\s+\(\s*\?\s*,\s*\?\s*,\s*\?\s*\)\s*$/m',
				$insert->getSql()
			),
			$insert->getSql()
		);
	}
	
	
	
	public function testANonPreparedInsertIsProperlyGenerated()
	{
		$insert	= $this->getInsert('test', array('a', 'b', 'c'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		
		$this->assertEquals(1, 
			preg_match(
				'/^\s*INSERT\s+INTO\s+`test`\s+\(\s*`a`\s*,\s*`b`\s*,\s*`c`\s*\)\s+VALUES\s+\(\s*\'e\\\\"\'\s*,\s*\'f\'\s*,\s*\'\\\\\'d\'\s*\)\s*$/m',
				$insert->getSql($params)
			),
			$insert->getSql($params)
		);
	}
}