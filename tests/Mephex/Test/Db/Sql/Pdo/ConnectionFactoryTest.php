<?php



class Mephex_Test_Db_Sql_Pdo_ConnectionFactoryTest
extends Mephex_Test_TestCase
{
	protected $_connection_factory = null;
	
	
	
	/**
	 * Deallocates any resources created by a test case.
	 */
	protected function tearDown()
	{
		$this->_connection_factory	= null;
	} 
	
	
	
	/**
	 * Lazy-loads the connection factory.
	 * 
	 * @return Mephex_Test_Db_Sql_Pdo_ConnectionFactory
	 */
	public function getConnectionFactory()
	{
		if(null === $this->_connection_factory)
		{ 
			$this->_connection_factory = new Stub_Mephex_Test_Db_Sql_Pdo_ConnectionFactory();
		}
		
		return $this->_connection_factory;
	}
	
	
	
	public function testDefaultCredentialFactoryIsATestCredentialFactory()
	{
		$factory	= $this->getConnectionFactory();
		
		$this->assertTrue(
			$factory->getDefaultCredentialFactory()
			instanceof
			Mephex_Test_Db_Sql_Pdo_CredentialFactory 
		);
	}
}  