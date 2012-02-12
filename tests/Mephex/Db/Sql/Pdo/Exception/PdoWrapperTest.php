<?php



class Mephex_Db_Sql_Pdo_Exception_PdoWrapperTest
extends Mephex_Test_TestCase
{
	protected $_pdo_exception;

	protected $_exception;



	public function setUp()
	{
		parent::setUp();
		$this->_pdo_exception	= new PDOException('');

		$this->_exception		= new Mephex_Db_Sql_Pdo_Exception_PdoWrapper(
			$this->_pdo_exception
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper::__construct
	 * @expectedException Mephex_Db_Sql_Pdo_Exception_PdoWrapper
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper::__construct
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper::getPdoException
	 */
	public function testPdoExceptionIsSamePassedToConstructor()
	{
		$this->assertSame(
			$this->_pdo_exception,
			$this->_exception->getPdoException()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper::__construct
	 */
	public function testDefaultMessageStartsAsExpected()
	{
		$this->assertStringStartsWith(
			'PDO error',
			$this->_exception->getMessage()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper::__construct
	 */
	public function testMessageStartCanBeCustomized()
	{
		$exception	= new Mephex_Db_Sql_Pdo_Exception_PdoWrapper(
			$this->_pdo_exception,
			'Custom error here!'
		);
		$this->assertStringStartsWith(
			'Custom error here!',
			$exception->getMessage()
		);
	}
}