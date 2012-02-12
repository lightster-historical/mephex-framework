<?php



class Mephex_Db_Sql_Pdo_CredentialTest
extends Mephex_Test_TestCase
{
	protected $_quoter;
	protected $_credential_details_a;
	protected $_credential_details_b;

	protected $_credential;
	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_quoter					= new Mephex_Db_Sql_Base_Quoter_Sqlite();
		$this->_credential_details_a	= new Mephex_Db_Sql_Pdo_CredentialDetails(
			'dsn_a',
			'username_a',
			'password_a',
			array('driver_options_a')
		);
		$this->_credential_details_b	= new Mephex_Db_Sql_Pdo_CredentialDetails(
			'dsn_b',
			'username_b',
			'password_b',
			array('driver_options_b')
		);

		$this->_credential				= new Mephex_Db_Sql_Pdo_Credential(
			$this->_quoter,
			$this->_credential_details_a,
			$this->_credential_details_b
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_Credential::__construct
	 */
	public function testCredentialCanBeConstructed()
	{
		$this->assertTrue(
			$this->_credential
			instanceof
			Mephex_Db_Sql_Base_Credential
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Credential::getQuoter
	 */
	public function testQuoterPassedToConstructorIsSameRetrieved()
	{
		$this->assertTrue(
			$this->_quoter
			===
			$this->_credential->getQuoter()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Credential::getWriteCredential
	 */
	public function testWriteCredentialPassedToConstructorIsSameRetrieved()
	{
		$this->assertTrue(
			$this->_credential_details_a
			===
			$this->_credential->getWriteCredential()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Credential::getReadCredential
	 */
	public function testReadCredentialPassedToConstructorIsSameRetrieved()
	{
		$this->assertTrue(
			$this->_credential_details_b
			===
			$this->_credential->getReadCredential()
		);
	}
}