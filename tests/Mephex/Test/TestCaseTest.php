<?php



class Mephex_Test_TestCaseTest
extends Mephex_Test_TestCase
{
	public function testGetConfigReturnsAConfigOptionSet()
	{
		$this->assertTrue($this->getConfig() instanceof Mephex_Config_OptionSet);
	}
	
	
	
	public function testGetConfigAlwaysReturnsSameInstance()
	{
		$this->assertTrue($this->getConfig() === $this->getConfig());
	}
	
	
	
	public function testGetConfigLoadersReturnsAnArrayOfConfigLoaders()
	{
		$config_loaders	= $this->getConfigLoaders();
		
		$this->assertTrue(is_array($config_loaders));
		foreach($config_loaders as $config_loader)
		{
			$this->assertTrue($config_loader instanceof Mephex_Config_Loader);
		}
	}
	
	
	
	public function testDbConnectionFactoryIsReusedWithinATestCase()
	{
		$conn_factory_1	= $this->getDbConnectionFactory();
		$conn_factory_2	= $this->getDbConnectionFactory();
		
		$this->assertTrue($conn_factory_1 === $conn_factory_2);
	}
	
	
	
	public function testNewDbConnectionFactoryIsCreatedForEveryTestCase()
	{
		$conn_factory_1	= $this->getDbConnectionFactory();
		$this->tearDown();
		
		$this->setUp();
		$conn_factory_2	= $this->getDbConnectionFactory();
		$this->tearDown();
		
		$this->setUp();
		$this->assertFalse($conn_factory_1 === $conn_factory_2);
	}
	
	
	
	public function testDbConnectionIsReusedWithinATestCase()
	{
		$conn_1	= $this->getDbConnection('sqlite', 'database');
		$conn_2	= $this->getDbConnection('sqlite', 'database');
		
		$this->assertTrue($conn_1 === $conn_2);
	}
	
	
	
	public function testNewDbConnectionIsCreatedForEveryTestCase()
	{
		$conn_1	= $this->getDbConnection('sqlite', 'database');
		$this->tearDown();
		
		$this->setUp();
		$conn_2	= $this->getDbConnection('sqlite', 'database');
		$this->tearDown();
		
		$this->setUp();
		$this->assertFalse($conn_1 === $conn_2);
	}
	
	
	
	public function testLoadPhpunitXmlDataSetIntoDb()
	{
		$conn	= $this->getDbConnection('sqlite', 'database');
		$this->loadXmlDataSetIntoDb($conn, 'Mephex_Test', 'basic');
		
		$results	= $conn->read('SELECT SUM(id) AS sum FROM sum_test')->execute();
		$results->rewind();
		$result		= $results->current();
		$this->assertEquals(12345, $result['sum']);
	}
}  