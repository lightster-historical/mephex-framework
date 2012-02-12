<?php



class Mephex_Db_Sql_Base_QueryTest
extends Mephex_Test_TestCase
{
	protected $_connection	= null;
	
	
	
	public function setUp()
	{	
		$this->_connection	= new Stub_Mephex_Db_Sql_Base_Connection(
			new Stub_Mephex_Db_Sql_Base_Credential(
				new Mephex_Db_Sql_Base_Quoter_Mysql()
			)
		);
	}
	
	
	
	protected function getQuery($sql = '', $prepared = Mephex_Db_Sql_Base_Query::PREPARE_NATIVE)
	{
		return new Stub_Mephex_Db_Sql_Base_Query($this->_connection, $sql, $prepared);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Base_Query::__construct
	 * @covers Mephex_Db_Sql_Base_Query::getConnection
	 */
	public function testConnectionIsSameObjectPassedToConstructor()
	{
		$this->assertTrue($this->_connection === $this->getQuery()->getConnection());
	}
	
	

	/**
	 * @covers Mephex_Db_Sql_Base_Query::getDerivedPreparedSetting
	 * @dataProvider providerForPreparedSettingDerivation
	 */
	public function testDerivePreparedSettingOffConnectionSetting(
		$query_setting,
		$connection_setting,
		$derived_setting
	)
	{
		$query	= $this->getQuery('', $query_setting);
		$this->_connection->setPreparedSetting($connection_setting);
		$this->assertEquals(
			$derived_setting, 
			$query->getDerivedPreparedSetting()
		);
	}



	public function providerForPreparedSettingDerivation()
	{
		return array(
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_OFF,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_OFF,
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_OFF,
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED,
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED,
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED,
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE,
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF,
				Mephex_Db_Sql_Base_Query::PREPARE_OFF
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE,
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED,
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE,
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE,
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE
			),
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Base_Query::getSql
	 */
	public function testSqlUsedIsSqlPassedToQueryConstructor()
	{
		$sql	= 'SELECT someField FROM someTable';
		$this->assertEquals($sql, $this->getQuery($sql)->getSql());
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Base_Query::getFetchMode
	 */
	public function testFetchModeIsNamedColumnsByDefault()
	{
		$this->assertEquals(
			Mephex_Db_Sql_Base_Query::FETCH_NAMED,
			$this->getQuery()->getFetchMode()
		);
	}



	/**
	 * @covers Mephex_Db_Sql_Base_Query::getFetchMode
	 * @covers Mephex_Db_Sql_Base_Query::setFetchMode
	 * @dataProvider providerForFetchModeCanBeSet
	 */
	public function testFetchModeCanBeSet($fetch_mode)
	{
		$query		= $this->getQuery();
		$query->setFetchMode($fetch_mode);
		$this->assertEquals($fetch_mode, $query->getFetchMode());	
	}



	public function providerForFetchModeCanBeSet()
	{
		return array(
			array(Mephex_Db_Sql_Base_Query::FETCH_NAMED),
			array(Mephex_Db_Sql_Base_Query::FETCH_NUMERIC),
			array(
				Mephex_Db_Sql_Base_Query::FETCH_NAMED
				| Mephex_Db_Sql_Base_Query::FETCH_NUMERIC
			),
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Base_Query::execute
	 * @dataProvider providerForTestingExecuteMethods
	 */
	public function testProperExecuteMethodIsCalledBasedOnPreparedSetting(
		$prepared_setting,
		$method_name
	)
	{
		$query	= $this->getMock(
			'Mephex_Db_Sql_Base_Query',
			array(
				'executeNativePrepare',
				'executeEmulatedPrepare',
				'executeNonPrepare',
			),
			array(
				$this->_connection,
				'',
				$prepared_setting
			)
		);

		$params	= array(
			'a',
			'bc',
			123
		);

		$query
			->expects($this->once())
			->method($method_name)
			->with($params);

		$query->execute($params);
	}



	public function providerForTestingExecuteMethods()
	{
		return array(
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_OFF,
				'executeNonPrepare',
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_EMULATED,
				'executeEmulatedPrepare',
			),
			array(
				Mephex_Db_Sql_Base_Query::PREPARE_NATIVE,
				'executeNativePrepare',
			),
		);
	}
}