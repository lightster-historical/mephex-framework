<?php



class Mephex_Test_Db_Sql_Pdo_CredentialFactoryTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory = null;
	
	
	
	/**
	 * Deallocates any resources created by a test case.
	 */
	protected function tearDown()
	{
		$this->_credential_factory	= null;
	} 
	
	
	
	/**
	 * Lazy-loads the credential factory.
	 * 
	 * @return Mephex_Test_Db_Sql_Pdo_CredentialFactory
	 */
	public function getCredentialFactory()
	{
		if(null === $this->_credential_factory)
		{ 
			$this->_credential_factory = new Stub_Mephex_Test_Db_Sql_Pdo_CredentialFactory();
		}
		
		return $this->_credential_factory;
	}
	
	
	
	public function testPossibleClassNamesAreReasonable()
	{
		$class_names	= $this->getCredentialFactory()->getDbmsClassNames('Abc');
		
		$this->assertEquals('Mephex_Test_Db_Sql_Pdo_CredentialFactory_Abc', array_shift($class_names));
		$this->assertEquals('Mephex_Db_Sql_Pdo_CredentialFactory_Abc', array_shift($class_names));
		$this->assertEquals('Abc', array_shift($class_names));
		$this->assertEmpty($class_names);
	}
}  