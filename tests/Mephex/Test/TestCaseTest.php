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
}  