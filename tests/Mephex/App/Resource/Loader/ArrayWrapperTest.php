<?php



class Mephex_App_Resource_Loader_ArrayWrapperTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_App_Resource_Loader_ArrayWrapper::__construct
	 */
	public function testClassIsInstantiable()
	{
		$this->assertInstanceOf(
			'Mephex_App_Resource_Loader_ArrayWrapper',
			new Mephex_App_Resource_Loader_ArrayWrapper(
				'some_class_name',
				array(
					'some_resource_name1'	=> 'some_resource_obj1',
					'some_resource_name2'	=> 'some_resource_obj2',
				)
			)
		);
	}



	/**
	 * @covers Mephex_App_Resource_Loader_ArrayWrapper::__construct
	 * @covers Mephex_App_Resource_Loader::getClassName
	 * @covers Mephex_App_Resource_Loader::loadResource
	 */
	public function testArrayWrapperImplementsResourceLoader()
	{
		$this->assertInstanceOf(
			'Mephex_App_Resource_Loader',
			new Mephex_App_Resource_Loader_ArrayWrapper(
				'some_class_name',
				array(
					'some_resource_name1'	=> 'some_resource_obj1',
					'some_resource_name2'	=> 'some_resource_obj2',
				)
			)
		);
	}



	/**
	 * @covers Mephex_App_Resource_Loader_ArrayWrapper::getClassName
	 * @dataProvider providerForClassNameCanBeRetrieved
	 * @depends testClassIsInstantiable
	 */
	public function testClassNameCanBeRetrieved($class_name)
	{
		$loader	= new Mephex_App_Resource_Loader_ArrayWrapper(
			$class_name,
			array()
		);
		$this->assertEquals($class_name, $loader->getClassName());
	}



	public function providerForClassNameCanBeRetrieved()
	{
		return array(
			array('some_class_name1'),
			array('some_class_name2'),
		);
	}



	/**
	 * @covers Mephex_App_Resource_Loader_ArrayWrapper::loadResource
	 * @dataProvider providerForResources
	 * @depends testClassIsInstantiable
	 */
	public function testResourceCanBeRetrieved($class_name, array $resources)
	{
		$loader	= new Mephex_App_Resource_Loader_ArrayWrapper(
			$class_name,
			$resources
		);

		$this->assertEquals(
			$resources["{$class_name}a"],
			$loader->loadResource("{$class_name}a")
		);
		$this->assertEquals(
			$resources["{$class_name}b"],
			$loader->loadResource("{$class_name}b")
		);
	}



	/**
	 * @covers Mephex_App_Resource_Loader_ArrayWrapper::loadResource
	 * @dataProvider providerForResources
	 * @depends testClassIsInstantiable
	 * @expectedException Mephex_App_Resource_Exception_UnknownResource
	 */
	public function testUnknownResourceTriggersException($class_name, array $resources)
	{
		$loader	= new Mephex_App_Resource_Loader_ArrayWrapper(
			$class_name,
			$resources
		);

		$loader->loadResource("{$class_name}c");
	}



	public function providerForResources()
	{
		return array(
			array(
				'some_class_name1',
				array(
					'some_class_name1a'	=> 'some_class_name1a_obj',
					'some_class_name1b'	=> 'some_class_name1b_obj',
				),
			),
			array(
				'some_class_name2',
				array(
					'some_class_name2a'	=> 'some_class_name2c_obj',
					'some_class_name2b'	=> 'some_class_name2d_obj',
				)
			),
		);
	}
}