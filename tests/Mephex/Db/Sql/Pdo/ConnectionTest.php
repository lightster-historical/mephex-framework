<?php



class Mephex_Db_Sql_Pdo_ConnectionTest
extends Mephex_Test_TestCase
{
	protected $_write_details;
	protected $_read_details;
	protected $_credential;
	protected $_connection;



	public function setUp()
	{
		parent::setUp();

		$db_rw		= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$this->_write_details	= new Mephex_Db_Sql_Pdo_CredentialDetails("sqlite:{$db_rw}");
		$this->_read_details	= new Mephex_Db_Sql_Pdo_CredentialDetails("sqlite:{$db_rw}");
		$this->_credential		= new Mephex_Db_Sql_Pdo_Credential(
			new Mephex_Db_Sql_Base_Quoter_Sqlite(),
			$this->_write_details,
			$this->_read_details
		);
		$this->_connection		= new Stub_Mephex_Db_Sql_Pdo_Connection($this->_credential);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::__construct
	 */
	public function testConnectionIsInstantiable()
	{
		$this->assertInstanceOf(
			'Mephex_Db_Sql_Pdo_Connection',
			$this->_connection
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::__construct
	 */
	public function testCredentialIsPassedToParentClass()
	{

		$this->assertAttributeSame(
			$this->_credential,
			'_credential',
			$this->_connection
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::__construct
	 */
	public function testWriteCredentialIsProperlyPulledFromCredential()
	{
		$this->assertAttributeSame(
			$this->_write_details,
			'_write_credential',
			$this->_connection
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::__construct
	 */
	public function testReadCredentialIsProperlyPulledFromCredential()
	{
		$this->assertAttributeSame(
			$this->_read_details,
			'_read_credential',
			$this->_connection
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::getConnectionUsingCredential
	 */
	public function testPdoConnectionCanBeMadeUsingCredential()
	{
		$this->assertInstanceOf(
			'Pdo',
			$this->_connection->getConnectionUsingCredential($this->_read_details)
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::getConnectionUsingCredential
	 * @expectedException Mephex_Db_Sql_Pdo_Exception_PdoWrapper
	 */
	public function testAnExceptionIsThrownWhenAConnectionCannotBeMade()
	{
		$details	= new Mephex_Db_Sql_Pdo_CredentialDetails('unknown:dbms');
		$this->_connection->getConnectionUsingCredential($details);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::getWriteConnection
	 */
	public function testWriteConnectionCanBeRetrieved()
	{
		$this->assertInstanceOf(
			'Pdo',
			$this->_connection->getWriteConnection()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::getWriteConnection
	 */
	public function testWriteConnectionIsLazyLoaded()
	{
		$pdo_conn	= $this->_connection->getWriteConnection();
		$this->assertSame(
			$pdo_conn,
			$this->_connection->getWriteConnection()
		);
	}
	


	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::getReadConnection
	 */
	public function testReadConnectionCanBeRetrieved()
	{
		$this->assertInstanceOf(
			'Pdo',
			$this->_connection->getReadConnection()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::getReadConnection
	 */
	public function testReadConnectionIsLazyLoaded()
	{
		$pdo_conn	= $this->_connection->getReadConnection();
		$this->assertSame(
			$pdo_conn,
			$this->_connection->getReadConnection()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::getReadConnection
	 */
	public function testWriteConnectionIsUsedForReadConnectionIfReadCredentialIsSameAsWriteCredential()
	{
		$db_rw			= $this->getSqliteDatabase('Mephex_Db_Sql_Pdo', 'basic');
		$details		= new Mephex_Db_Sql_Pdo_CredentialDetails("sqlite:{$db_rw}");
		$connection		= new Stub_Mephex_Db_Sql_Pdo_Connection(
			new Mephex_Db_Sql_Pdo_Credential(
				new Mephex_Db_Sql_Base_Quoter_Sqlite(),
				$details,
				$details
			)
		);

		$this->assertSame(
			$connection->getWriteConnection(),
			$connection->getReadConnection()
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::write
	 */
	public function testWriteReturnsWriteQuery()
	{
		$query	= $this->_connection->write('INSERT ...');
		$this->assertTrue($query instanceof Mephex_Db_Sql_Pdo_Query_Write);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::read
	 */
	public function testReadReturnsReadQuery()
	{
		$query	= $this->_connection->read('SELECT ...');
		$this->assertTrue($query instanceof Mephex_Db_Sql_Pdo_Query_Read);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::__destruct
	 */
	public function testConnectionCanBeDestroyed()
	{
		$this->_connection->__destruct();

		$this->assertAttributeSame(
			null,
			'_write_connection',
			$this->_connection
		);
		$this->assertAttributeSame(
			null,
			'_read_connection',
			$this->_connection
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Pdo_Connection::read
	 */
	public function testQueryCanBeRun()
	{
		$known		= array(
			'lightster'				=> 'Matt Light'
		);
		
		$this->assertTrue(count($known) > 0);
		
		$mismatch	= 0;
		$developers	= $this->_connection->read('SELECT * FROM developer');
		foreach($developers->execute() as $developer)
		{
			if(!empty($known[$developer['nickname']])
				&& $known[$developer['nickname']] === $developer['name'])
			{
				unset($known[$developer['nickname']]);
			}
			else
			{
				$mismatch++;
			}
		}

		$mismatch	+= count($known);
		
		$this->assertEquals(0, $mismatch);
	}
}