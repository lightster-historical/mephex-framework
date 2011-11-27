<?php



class Mephex_Db_CredentialFactoryTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_credential_factory	= new Stub_Mephex_Db_CredentialFactory();
	}



	/**
	 * @covers Mephex_Db_CredentialFactory
	 */
	public function testInterfaceIsImplementable()
	{
		$this->assertTrue(
			$this->_credential_factory
			instanceof
			Mephex_Db_CredentialFactory
		);
	}
}