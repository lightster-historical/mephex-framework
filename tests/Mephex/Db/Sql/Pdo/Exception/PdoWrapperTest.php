<?php



class Mephex_Db_Sql_Pdo_Exception_PdoWrapperTest
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

		$this->_exception		= new Mephex_Db_Sql_Pdo_Exception_PdoWrapper(
			$this->_connection,
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
	 * @covers Mephex_Db_Sql_Pdo_Exception_PdoWrapper::getConnection
	 */
	public function testConnectionIsSamePassedToConstructor()
	{
		$this->assertSame(
			$this->_connection,
			$this->_exception->getConnection()
		);
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
	public function testMessageStartsWtihPdoErrorByDefault()
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