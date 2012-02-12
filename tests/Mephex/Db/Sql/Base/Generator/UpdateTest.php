<?php



class Mephex_Db_Sql_Base_Generator_UpdateTest
extends Mephex_Test_TestCase
{
	protected $_update	= null;
	
	
	
	protected function tearDown()
	{	
		parent::tearDown();
		
		$this->_update	= null;
	}
	
	
	
	public function getUpdate($table, array $update_columns, array $where_columns, $quoter = null)
	{
		if(null === $this->_update)
		{
			if(null === $quoter)
			{
				$quoter	= new Mephex_Db_Sql_Base_Quoter_Mysql();
			}
			$this->_update	= new Stub_Mephex_Db_Sql_Base_Generator_Update($quoter, $table, $update_columns, $where_columns);
		}
		
		return $this->_update;
	}
	
	
	
	public function testUpdateGeneratorIsGenerator()
	{
		$this->assertTrue(
			$this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'))
			instanceof 
			Mephex_Db_Sql_Base_Generator
		);
	}
	
	
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAQuoterIsRequired()
	{
		$update	= new Stub_Mephex_Db_Sql_Base_Generator_Update('test', array('abc', 'def'), array('xyz'));
	}
	
	
	
	public function testQuoterProvidedToTheConstructorIsUsedByInsert()
	{
		$quoter	= new Mephex_Db_Sql_Base_Quoter_Mysql();
		$insert	= $this->getUpdate('test', array('abc', 'def'), array('xyz'), $quoter);
		
		$this->assertTrue($insert->getQuoter() instanceof Mephex_Db_Sql_Base_Quoter);
		$this->assertTrue($insert->getQuoter() === $quoter);
	}
	
	
	
	public function testUpdateParametersAreReturnedInCorrectOrderAndAreNotQuoted()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'));
		
		$params	= array
		(
			'c'	=> 'd',
			'a'	=> 'e',
			'b'	=> 'f'
		);
		$expected	= array('e', 'f', 'd');
		$ordered	= $update->getUpdateColumnOrderedValues($params, false);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	public function testUpdateParametersAreReturnedInCorrectOrderAndAreQuoted()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $update->getUpdateColumnOrderedValues($params, true);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAMissingUpdateParameterCausesAnExceptionToBeThrown()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c', 'x'), array('x', 'y'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $update->getUpdateColumnOrderedValues($params, true);
	}
	
	
	
	public function testWhereParametersAreReturnedInCorrectOrderAndAreNotQuoted()
	{
		$update	= $this->getUpdate('test', array('x', 'y'), array('a', 'b', 'c'));
		
		$params	= array
		(
			'c'	=> 'd',
			'a'	=> 'e',
			'b'	=> 'f'
		);
		$expected	= array('e', 'f', 'd');
		$ordered	= $update->getWhereColumnOrderedValues($params, false);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	public function testWhereParametersAreReturnedInCorrectOrderAndAreQuoted()
	{
		$update	= $this->getUpdate('test', array('x', 'y'), array('a', 'b', 'c'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $update->getWhereColumnOrderedValues($params, true);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAMissingWhereParameterCausesAnExceptionToBeThrown()
	{
		$update	= $this->getUpdate('test', array('x', 'y'), array('a', 'b', 'c', 'x'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $update->getWhereColumnOrderedValues($params, true);
	}
	
	
	
	public function testMixedParametersAreReturnedInCorrectOrderAndAreNotQuoted()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'y'	=> '\'u',
			'a'	=> 'e"',
			'b'	=> 'f',
			'x'	=> 'v"',
		);
		$expected	= array(
			'e"', 
			'f', 
			'\'d',
			'v"',
			'\'u'
		);
		$ordered	= $update->getColumnOrderedValues($params, false);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	public function testMixedParemetersAreReturnedInCorrectOrderAndAreQuoted()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c', 'x'), array('x', 'y'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'y'	=> '\'u',
			'a'	=> 'e"',
			'b'	=> 'f',
			'x'	=> 'v"',
		);
		$expected	= array(
			'\'e\\"\'', 
			'\'f\'', 
			'\'\\\'d\'',
			'\'v\\"\'',
			'\'v\\"\'',
			'\'\\\'u\''
		);
		$ordered	= $update->getColumnOrderedValues($params, true);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAMissingMixedUpdateParameterCausesAnExceptionToBeThrown()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'));
		
		$params	= array
		(
			'y'	=> '\'u',
			'a'	=> 'e"',
			'b'	=> 'f',
			'x'	=> 'v"',
		);
		$ordered	= $update->getColumnOrderedValues($params, false);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAMissingMixedWhereParameterCausesAnExceptionToBeThrown()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'));
		
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f',
			'x'	=> 'v"',
		);
		$ordered	= $update->getColumnOrderedValues($params, false);
	}
	
	
	
	public function testAPreparedUpdateIsProperlyGenerated()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'));
		
		$this->assertEquals(1, 
			preg_match(
				'/^\s*UPDATE\s+`test`\s+SET\s+`a`\s*=\s*\?\s*,\s*`b`\s*=\s*\?\s*,\s*`c`\s*=\s*\?\s+WHERE\s+`x`\s*=\s*\?\s+AND\s+`y`\s*=\s*\?\s*$/m',
				$update->getSql()
			),
			$update->getSql()
		);
	}
	
	
	
	public function testANonPreparedInsertIsProperlyGenerated()
	{
		$update	= $this->getUpdate('test', array('a', 'b', 'c'), array('x', 'y'));
		
		$update_params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$where_params	= array
		(
			'y'	=> '\'u',
			'x'	=> 'v"',
		);
		
		$this->assertEquals(1, 
			preg_match(
			//
				'/^\s*UPDATE\s+`test`\s+SET\s+`a`\s*=\s*\'e\\\"\'\s*,\s*`b`\s*=\s*\'f\'\s*,\s*`c`\s*=\s*\'\\\\\'d\'\s+WHERE\s+`x`\s*=\s*\'v\\\"\'\s+AND\s+`y`\s*=\s*\'\\\\\'u\'\s*$/m',
				$update->getSql($update_params, $where_params)
			),
			$update->getSql($update_params, $where_params)
		);
	}
}