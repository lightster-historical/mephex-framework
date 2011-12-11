<?php



class Mephex_Db_Sql_Pdo_Exception_UnknownDbmsTest
extends Mephex_Test_TestCase
{
	private $_credential_factory;
	private $_dbms;
	private $_classes;

	private $_exception;



	public function setUp()
	{
		$this->_credential_factory	= new Mephex_Db_Sql_Pdo_CredentialFactory_Configurable(
			new Mephex_Config_OptionSet(),
			'some_group'
		);
		$this->_dbms				= 'a_dbms';
		$this->_classes				= array(
			'SomeClass',
			'SomeOtherClass',
		);

		$this->_exception	= new Mephex_Db_Sql_Pdo_Exception_UnknownDbms(
			$this->_credential_factory,
			$this->_dbms,
			$this->_classes
		);
	}



	/**
	 * @expectedException Mephex_Db_Sql_Pdo_Exception_UnknownDbms
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownDbms::__construct 
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownDbms::getCredentialFactory 
	 */
	public function testCredentialFactoryCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_credential_factory,
			$this->_exception->getCredentialFactory()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownDbms::__construct 
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownDbms::getDbms 
	 */
	public function testDbmsCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_dbms,
			$this->_exception->getDbms()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownDbms::__construct 
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownDbms::getClasses 
	 */
	public function testClassesCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_classes,
			$this->_exception->getClasses()
		);
	}
}