<?php



class Mephex_Test_Db_ConnectionFactoryTest
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
	 * @param Mephex_Test_TmpFileCopier
	 * @return Mephex_Test_Db_ConnectionFactory
	 */
	public function getConnectionFactory(Mephex_Test_TmpFileCopier $tmp_copier = null)
	{
		if(null === $this->_connection_factory)
		{ 
			if(!$tmp_copier)
			{
				$tmp_copier	= new Mephex_Test_TmpFileCopier(PATH_TEST_ROOT . "/tmp");
			}
			$this->_connection_factory = new Stub_Mephex_Test_Db_ConnectionFactory($tmp_copier);
		}
		
		return $this->_connection_factory;
	}
	
	
	
	public function testTmpFileCopierIsSamePassedToConstructor()
	{
		$tmp_copier	= new Mephex_Test_TmpFileCopier(PATH_TEST_ROOT . "/tmp");
		$factory	= $this->getConnectionFactory($tmp_copier);
		
		$this->assertTrue($factory->getTmpCopier() === $tmp_copier);
	}
	
	
	
	public function testPossibleClassNamesAreReasonable()
	{
		$class_names	= $this->getConnectionFactory()->getDriverClassNames('Abc');
		
		$this->assertEquals('Mephex_Test_Db_Sql_Abc_ConnectionFactory', array_shift($class_names));
		$this->assertEquals('Mephex_Db_Sql_Abc_ConnectionFactory', array_shift($class_names));
		$this->assertEquals('Abc', array_shift($class_names));
		$this->assertEmpty($class_names);
	}
	
	
	
	public function testConnectionCanBeMade()
	{
		$config	= new Mephex_Config_OptionSet();
		$config->addLoader(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'config.ini'
			)
		);
		
		$conn	= $this->getConnectionFactory()->connectUsingConfig(
			$config, 
			'database',
			'sqlite'
		);
		$this->assertTrue($conn instanceof Mephex_Db_Sql_Base_Connection);
	}
	
	
	
	public function testTmpCopierIsAddedToConfigOptions()
	{
		$config	= new Mephex_Config_OptionSet();
		$config->addLoader(
			new Mephex_Config_Loader_Ini(
				PATH_TEST_ROOT . DIRECTORY_SEPARATOR . 'config.ini'
			)
		);
		
		$this->getConnectionFactory()->connectUsingConfig(
			$config, 
			'database',
			'sqlite'
		);
		$this->assertTrue($config->hasOption('database', 'sqlite.tmp_copier'));
		$this->assertTrue(
			$config->get('database', 'sqlite.tmp_copier')
			instanceof
			Mephex_Test_TmpFileCopier
		);
	}
}  