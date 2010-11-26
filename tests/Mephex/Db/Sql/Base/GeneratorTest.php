<?php



class Mephex_Db_Sql_Base_GeneratorTest
extends Mephex_Test_TestCase
{
	protected $_quoter		= null;
	protected $_generator	= null;
	
	
	
	public function setUp()
	{
		$this->_quoter		= new Mephex_Db_Sql_Base_Quoter();
		$this->_generator	= new Stub_Mephex_Db_Sql_Base_Generator($this->_quoter);
	}
	
	
	
	public function testQuoterProvidedToTheConstructorIsUsedByGenerator()
	{
		$this->assertTrue($this->_generator->getQuoter() instanceof Mephex_Db_Sql_Quoter);
		$this->assertTrue($this->_generator->getQuoter() === $this->_quoter);
	}
	
	

	public function testParameterIsReturnedAndIsNotQuoted()
	{
		$params	= array
		(
			'c'	=> 'd',
			'a'	=> 'e',
			'b'	=> 'f'
		);
		
		$this->assertEquals('e', $this->_generator->getValue('a', $params, false));
		$this->assertEquals('f', $this->_generator->getValue('b', $params, false));
		$this->assertEquals('d', $this->_generator->getValue('c', $params, false));
	}
	
	
	
	public function testParameterIsReturnedAndIsQuoted()
	{
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		
		$this->assertEquals('\'e\\"\'', $this->_generator->getValue('a', $params, true));
		$this->assertEquals('\'f\'', $this->_generator->getValue('b', $params, true));
		$this->assertEquals('\'\\\'d\'', $this->_generator->getValue('c', $params, true));
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAMissingParameterCausesAnExceptionToBeThrown()
	{
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$this->_generator->getValue('x', $params, false);
	}
	
	
	
	public function testParametersAreReturnedInCorrectOrderAndAreNotQuoted()
	{
		$order	= array('a', 'b', 'c');
		$params	= array
		(
			'c'	=> 'd',
			'a'	=> 'e',
			'b'	=> 'f'
		);
		$expected	= array('e', 'f', 'd');
		$ordered	= $this->_generator->getOrderedValues($order, $params, false);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	public function testParametersAreReturnedInCorrectOrderAndAreQuoted()
	{
		$order	= array('a', 'b', 'c');
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $this->_generator->getOrderedValues($order, $params, true);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	/**
	 * @expectedException Mephex_Db_Exception
	 */
	public function testAMissingParametersCauseAnExceptionToBeThrown()
	{
		$order	= array('a', 'b', 'c', 'x');
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array('\'e\\"\'', '\'f\'', '\'\\\'d\'');
		$ordered	= $this->_generator->getOrderedValues($order, $params, true);
	}
	
	
	
	public function testAFieldValueStringCanBeGenerated()
	{
		$order	= array('a', 'b', 'c');
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array
		(
			'`a`=\'e\\"\'',
			'`b`=\'f\'',
			'`c`=\'\\\'d\'',
		);
		$ordered	= $this->_generator->getFieldValueStrings($order, $params);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
	
	
	
	public function testAFieldValueStringCanBeGeneratedWithPlaceholders()
	{
		$order	= array('a', 'b', 'c');
		$params	= array
		(
			'c'	=> '\'d',
			'a'	=> 'e"',
			'b'	=> 'f'
		);
		$expected	= array
		(
			'`a`=?',
			'`b`=?',
			'`c`=?',
		);
		$ordered	= $this->_generator->getFieldValueStrings($order);
		
		$this->assertEquals($expected, $ordered);
		$this->assertTrue($expected === $ordered);
	}
}