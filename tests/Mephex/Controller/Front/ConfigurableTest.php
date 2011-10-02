<?php



class Mephex_Controller_Front_ConfigurableTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_Controller_Front_Configurable
	 * @covers Mephex_Controller_Front_Configurable::__construct
	 */
	public function testConfigurableFrontControllerCanBeInstantiated()
	{
		$config		= new Mephex_Config_OptionSet();
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable($config);

		$this->assertTrue(
			$front_ctrl
			instanceof
			Mephex_Controller_Front_Configurable
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Configurable::getConfig
	 */
	public function testConfigCanBeRetrievedFromFrontController()
	{
		$config		= new Mephex_Config_OptionSet();
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable($config);

		$this->assertTrue($config === $front_ctrl->getConfig());
	}



	/**
	 * @covers Mephex_Controller_Front_Configurable::getSystemConfigOption
	 */
	public function testSystemConfigOptionCanBeRead()
	{
		$config		= new Mephex_Config_OptionSet();
		$config->set('mephex', 'some_opt', 'some_val');
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable($config);

		$this->assertEquals(
			'some_val',
			$front_ctrl->getSystemConfigOption('some_opt')
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Configurable::__construct
	 * @covers Mephex_Controller_Front_Configurable::getSystemConfigOption
	 * @depends testSystemConfigOptionCanBeRead
	 */
	public function testConfigSystemGroupCanBeSet()
	{
		$config		= new Mephex_Config_OptionSet();
		$config->set('not_mephex', 'some_opt', 'some_val');
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable(
			$config, 'not_mephex'
		);

		$this->assertEquals(
			'some_val',
			$front_ctrl->getSystemConfigOption('some_opt')
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Configurable::getSystemClassFromConfig
	 * @depends testSystemConfigOptionCanBeRead
	 */
	public function testSystemClassCanBeReadFromConfig()
	{
		$config		= new Mephex_Config_OptionSet();
		$config->set('mephex', 'router', 'Stub_Mephex_Controller_Router');
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable($config);

		$this->assertEquals(
			'Stub_Mephex_Controller_Router',
			$front_ctrl->getSystemClassFromConfig(
				'router',
				'Mephex_Controller_Router'
			)
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Configurable::getSystemClassFromConfig
	 * @depends testSystemConfigOptionCanBeRead
	 * @expectedException Mephex_Reflection_Exception_NonExistentClass
	 */
	public function testSystemClassMustExist()
	{
		$config		= new Mephex_Config_OptionSet();
		$config->set('mephex', 'router', 'Stub_Mephex_Controller_Router_Haha');
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable($config);

		$front_ctrl->getSystemClassFromConfig(
			'router',
			'Mephex_Controller_Router'
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Configurable::getSystemClassFromConfig
	 * @depends testSystemConfigOptionCanBeRead
	 * @expectedException Mephex_Reflection_Exception_UnexpectedClass
	 */
	public function testSystemClassMustInheritGivenClass()
	{
		$config		= new Mephex_Config_OptionSet();
		$config->set('mephex', 'router', 'Stub_Mephex_Controller_Front');
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable($config);

		$front_ctrl->getSystemClassFromConfig(
			'router',
			'Mephex_Controller_Router'
		);
	}



	/**
	 * @covers Mephex_Controller_Front_Configurable::generateDefaultRouter
	 * @depends testSystemConfigOptionCanBeRead
	 * @depends testSystemClassCanBeReadFromConfig
	 */
	public function testRouterCanBeGenerated()
	{
		$config		= new Mephex_Config_OptionSet();
		$config->set(
			'mephex',
			'router.class_name',
			'Stub_Mephex_Controller_Router_Front'
		);
		$front_ctrl	= new Stub_Mephex_Controller_Front_Configurable($config);

		$this->assertTrue(
			$front_ctrl->generateDefaultRouter()
			instanceof
			Stub_Mephex_Controller_Router_Front
		);
	}
}