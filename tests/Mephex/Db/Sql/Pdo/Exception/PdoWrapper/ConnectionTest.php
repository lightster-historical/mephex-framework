<?php



class Mephex_Db_Sql_Pdo_Exception_PdoWrapper_ConnectionTest
extends Mephex_Test_TestCase
{
	protected $_details;
	protected $_credential;
	protected $_connection;

	protected $_pdo_exception;

	protected $_exception;



	public function setUp()
	{
		parent::setUp();

		$this->_details		= new Mephex_Db_Sql_Pdo_CredentialDetails("");
		$this->_credential	= new Mephex_Db_Sql_Pdo_Credential(
			new Mephex_Db_Sql_Base_Quoter_Sqlite(),
			$this->_details,
			$this->_details
		);
		$this->_connection		= new Mephex_Db_Sql_Pdo_Connection($this->_credential);

		$this->_pdo_exception	= new PDOException('');

		$this->_exception		= new Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection(
			$this->_connection,
			$this->_pdo_exception
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection::__construct
	 * @expectedException Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection::__construct
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection::getConnection
	 */
	public function testConnectionIsSamePassedToConstructor()
	{
		$this->assertSame(
			$this->_connection,
			$this->_exception->getConnection()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection::__construct
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection::getPdoException
	 */
	public function testPdoExceptionIsSamePassedToConstructor()
	{
		$this->assertSame(
			$this->_pdo_exception,
			$this->_exception->getPdoException()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection::__construct
	 */
	public function testDefaultMessageStartsAsExpected()
	{
		$this->assertStringStartsWith(
			'PDO connection error',
			$this->_exception->getMessage()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection::__construct
	 */
	public function testMessageStartCanBeCustomized()
	{
		$exception	= new Mephex_Db_Sql_Pdo_Exception_PdoWrapper_Connection(
			$this->_connection,
			$this->_pdo_exception,
			'Custom error here!'
		);
		$this->assertStringStartsWith(
			'Custom error here!',
			$exception->getMessage()
		);
	}
}