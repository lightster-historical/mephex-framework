<?php



class Mephex_App_ArgumentsTest
extends Mephex_Test_TestCase
{
	protected $_args;
	
	protected $_default_args;
	
	
	
	protected function setUp()
	{
		parent::setUp();
		
		$this->_default_args	= array
		(
			'a'		=> 12,
			'b'		=> 24,
			'c'		=> array
			(
				'c'		=> null
			),
			'd'		=> null
		);
		$this->_args	= new Mephex_App_Arguments($this->_default_args);
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::has
	 */
	public function testCanDetermineIfArgumentIsSet()
	{
		$this->assertTrue($this->_args->has('a'));
		$this->assertTrue($this->_args->has('b'));
		$this->assertTrue($this->_args->has('c'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::has
	 */
	public function testCanDetermineIfArgumentWithNullValueIsSet()
	{
		$this->assertTrue($this->_args->has('d'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::has
	 */
	public function testCanDetermineIfArgumentIsNotSet()
	{
		$this->assertFalse($this->_args->has('z'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::get
	 */
	public function testCanRetrieveArgument()
	{
		$this->assertEquals(12, $this->_args->get('a'));
		$this->assertEquals(24, $this->_args->get('b'));
		$this->assertEquals(array('c' => null), $this->_args->get('c'));
		$this->assertNull($this->_args->get('d', 'not_null'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::get
	 */
	public function testDefaultValueIsReturnedIfArgumentIsNotSet()
	{
		$this->assertEquals('some_default', $this->_args->get('z', 'some_default'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::get
	 * @expectedException Mephex_App_Arguments_Exception_UnknownKey
	 */
	public function testExceptionIsThrownIfRequestedKeyIsNotFound()
	{
		$this->assertNull($this->_args->get('y'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::set
	 * @depends testCanRetrieveArgument
	 */
	public function testNewArgumentCanBeSet()
	{
		$this->_args->set('z', 'new_arg');
		$this->assertEquals('new_arg', $this->_args->get('z'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::set
	 * @depends testCanRetrieveArgument
	 */
	public function testArgumentValueCanBeChanged()
	{
		$this->_args->set('a', 'new_val');
		$this->assertEquals('new_val', $this->_args->get('a'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::setAll
	 * @depends testCanRetrieveArgument
	 */
	public function testManyNewArgumentsCanBeSet()
	{
		$this->_args->setAll(array
			(
				'y'		=> 'new_y',
				'z'		=> 'new_z'
			)
		);
		
		$this->assertEquals('new_y',	$this->_args->get('y'));
		$this->assertEquals('new_z',	$this->_args->get('z'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::setAll
	 * @depends testCanRetrieveArgument
	 */
	public function testManyArgumentValuesCanBeChanged()
	{
		$this->_args->setAll(array
			(
				'a'		=> 'new_a',
				'b'		=> 'new_b'
			)
		);
		
		$this->assertEquals('new_a',	$this->_args->get('a'));
		$this->assertEquals('new_b',	$this->_args->get('b'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::clear
	 * @depends testCanDetermineIfArgumentIsSet
	 */
	public function testArgumentsCanBeCleared()
	{
		$this->assertTrue($this->_args->has('a'));
		$this->assertTrue($this->_args->has('b'));
		$this->assertTrue($this->_args->has('c'));
		$this->assertTrue($this->_args->has('d'));
		$this->assertFalse($this->_args->has('z'));
		
		$this->_args->clear('a');
		$this->_args->clear('z');
		
		$this->assertFalse($this->_args->has('a'));
		$this->assertTrue($this->_args->has('b'));
		$this->assertTrue($this->_args->has('c'));
		$this->assertTrue($this->_args->has('d'));
		$this->assertFalse($this->_args->has('z'));
	}
	
	
	
	/**
	 * @covers Mephex_App_Arguments::clearAll
	 * @depends testCanDetermineIfArgumentIsSet
	 */
	public function testAllArgumentsCanBeCleared()
	{
		$this->assertTrue($this->_args->has('a'));
		$this->assertTrue($this->_args->has('b'));
		$this->assertTrue($this->_args->has('c'));
		$this->assertTrue($this->_args->has('d'));
		
		$this->_args->clearAll();
		
		$this->assertFalse($this->_args->has('a'));
		$this->assertFalse($this->_args->has('b'));
		$this->assertFalse($this->_args->has('c'));
		$this->assertFalse($this->_args->has('d'));
	}
}