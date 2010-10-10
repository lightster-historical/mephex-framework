<?php



class Mephex_Db_Sql_Pdo_CredentialTest
extends Mephex_Test_TestCase
{
	protected $_dsn;
	protected $_username;
	protected $_password;
	protected $_driver_options;
	
	protected $_credential;
	
	
	
	public function setUp()
	{	
		parent::setUp();
		
		$this->_dsn				= 'sqlite:some_db';
		$this->_username		= 'some_username';
		$this->_password		= 'some_password';
		$this->_driver_options	= array
		(
			'some_option'	=> 'some_value',
			'other_option'	=> 'other_value'
		);
		
		$this->_credential	= new Mephex_Db_Sql_Pdo_Credential(
			$this->_dsn,
			$this->_username,
			$this->_password,
			$this->_driver_options
		);
	}
	
	
	
	public function testDsnIsSameAsPassedToConstructor()
	{
		$this->assertEquals($this->_dsn, $this->_credential->getDataSourceName());
	}
	
	
	
	public function testUsernameIsSameAsPassedToConstructor()
	{
		$this->assertEquals($this->_username, $this->_credential->getUsername());
	}
	
	
	
	public function testPasswordIsSameAsPassedToConstructor()
	{
		$this->assertEquals($this->_password, $this->_credential->getPassword());
	}
	
	
	
	public function testDriverOptionsAreSameAsPassedToConstructor()
	{
		$driver_options	= $this->_credential->getDriverOptions();
		foreach($driver_options as $option => $value)
		{
			$this->assertEquals($this->_driver_options[$option], $value);
		}
	}
}  