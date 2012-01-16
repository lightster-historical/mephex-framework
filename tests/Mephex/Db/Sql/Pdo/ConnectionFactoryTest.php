<?php



class Mephex_Db_Sql_Pdo_ConnectionFactoryTest
extends Mephex_Test_TestCase
{
	protected $_credential_factory;
	protected $_connection_factory;
	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_credential_factory	= $this->getMock(
			'Mephex_Db_Sql_Base_CredentialFactory'
		);
		$this->_connection_factory	= new Mephex_Db_Sql_Pdo_ConnectionFactory(
			$this->_credential_factory
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_ConnectionFactory::__construct
	 */
	public function testCredentialFactoryIsSameAsPassedToConstructor()
	{
		$this->assertAttributeSame(
			$this->_credential_factory,
			'_credential_factory',
			$this->_connection_factory
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_ConnectionFactory::getConnection
	 */
	public function testAConnectionCanBeGenerated()
	{
		$credential	= new Mephex_Db_Sql_Pdo_Credential(
			new Mephex_Db_Sql_Base_Quoter_Mysql(),
			new Mephex_Db_Sql_Pdo_CredentialDetails('custom://dsn/db_write'),
			new Mephex_Db_Sql_Pdo_CredentialDetails('custom://dsn/db_read')
		);

		$this
			->_credential_factory
			->expects($this->any())
			->method('getCredential')
			->with($this->equalTo('conn_name'))
			->will($this->returnValue($credential))
		;

		$this->assertInstanceOf(
			'Mephex_Db_Sql_Pdo_Connection',
			$this->_connection_factory->getConnection('conn_name')
		);
	}
}  