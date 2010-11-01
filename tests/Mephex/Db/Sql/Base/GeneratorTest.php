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
	public function testAMissingParameterCausesAnExceptionToBeThrown()
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
}