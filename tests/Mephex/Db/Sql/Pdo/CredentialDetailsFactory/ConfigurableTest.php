<?php



class Mephex_Db_Sql_Pdo_CredentialDetailsFactory_ConfigurableTest
extends Mephex_Test_TestCase
{
	protected $_config;
	protected $_group;

	protected $_details_factory;
	
	
	
	public function setUp()
	{
		parent::setUp();

		$this->_config	= new Mephex_Config_OptionSet();
		$this->_group	= 'db_group';

		$this->_details_factory	= $this->getMock(
			'Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable',
			array(
				'getCredentialDetails',
				'getQuoter'
			),
			array(
				$this->_config,
				$this->_group
			)
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable::__construct
	 */
	public function testConfigIsProperlySet()
	{
		$this->assertSame(
			$this->_config,
			$this->readAttribute($this->_details_factory, '_config')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Db_Sql_Pdo_CredentialDetailsFactory_Configurable::__construct
	 */
	public function testGroupIsProperlySet()
	{
		$this->assertSame(
			$this->_group,
			$this->readAttribute($this->_details_factory, '_group')
		);
	}
}  