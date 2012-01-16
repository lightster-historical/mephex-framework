<?php



class Mephex_Db_Sql_Pdo_Exception_UnknownQuoterTest
extends Mephex_Test_TestCase
{
	private $_details_factory;
	private $_quoter_name;
	private $_classes;

	private $_exception;



	public function setUp()
	{
		$this->_details_factory	= $this->getMock(
			'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable',
			array(
				'getCredentialDetails',
				'getQuoter'
			),
			array(
				new Mephex_Config_OptionSet(),
				'some_group'
			)
		);
		$this->_quoter_name			= 'a_quoter_name';
		$this->_classes				= array(
			'SomeClass',
			'SomeOtherClass',
		);

		$this->_exception	= new Mephex_Db_Sql_Pdo_Exception_UnknownQuoter(
			$this->_details_factory,
			$this->_quoter_name,
			$this->_classes
		);
	}



	/**
	 * @expectedException Mephex_Db_Sql_Pdo_Exception_UnknownQuoter
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownQuoter::__construct 
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownQuoter::getCredentialDetailsFactory 
	 */
	public function testCredentialFactoryCanBeRetrieved()
	{
		$this->assertSame(
			$this->_details_factory,
			$this->_exception->getCredentialDetailsFactory()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownQuoter::__construct 
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownQuoter::getQuoterName 
	 */
	public function testQuoterNameCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_quoter_name,
			$this->_exception->getQuoterName()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownQuoter::__construct 
	 * @covers Mephex_Db_Sql_Pdo_Exception_UnknownQuoter::getClasses 
	 */
	public function testClassesCanBeRetrieved()
	{
		$this->assertEquals(
			$this->_classes,
			$this->_exception->getClasses()
		);
	}
}