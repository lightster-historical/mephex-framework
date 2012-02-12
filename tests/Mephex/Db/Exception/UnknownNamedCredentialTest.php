<?php



class Mephex_Db_Exception_UnknownNamedCredentialTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	protected $_credential_name;

	protected $_exception;
	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_credential_factory	= new Stub_Mephex_Db_Sql_Base_CredentialFactory();
		$this->_credential_name		= 'nameOfUnknownCredential';

		$this->_exception	= new Mephex_Db_Exception_UnknownNamedCredential(
			$this->_credential_factory,
			$this->_credential_name
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Exception_UnknownNamedCredential
	 * @expectedException Mephex_Db_Exception_UnknownNamedCredential
	 */
	public function testExceptionIsThrowable()
	{
		throw $this->_exception;
	}
	
	
	
	/**
	 * @covers Mephex_Db_Exception_UnknownNamedCredential
	 */
	public function testExceptionIsInstanceOfBaseDbExceptionClass()
	{
		$this->assertTrue(
			$this->_exception
			instanceof
			Mephex_Db_Exception
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Exception_UnknownNamedCredential::getCredentialFactory
	 */
	public function testCredentialFactoryIsRetrievable()
	{
		$this->assertTrue(
			$this->_credential_factory
			===
			$this->_exception->getCredentialFactory()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Exception_UnknownNamedCredential::getCredentialName
	 */
	public function testCredentialNameIsRetrievable()
	{
		$this->assertEquals(
			$this->_credential_name,
			$this->_exception->getCredentialName()
		);
	}
}  