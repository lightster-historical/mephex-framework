<?php



class Mephex_App_Resource_ListTest
extends Mephex_Test_TestCase
{
	protected $_list;



	public function setUp()
	{
		$this->_list	= new Stub_Mephex_App_Resource_List();
	}



	/**
	 * @covers Mephex_App_Resource_List::__construct
	 */
	public function testClassIsInstantiable()
	{
		$this->assertInstanceOf(
			'Mephex_App_Resource_List',
			new Mephex_App_Resource_List()
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::addType
	 * @dataProvider providerOfTypes
	 * @depends testClassIsInstantiable
	 */
	public function testClassNameIsAddedForType($type_name, $class_name)
	{
		$this->_list->addType($type_name, $class_name);
		$type_classes	= $this->readAttribute(
			$this->_list,
			'_type_classes'
		);

		$this->assertEquals($class_name, $type_classes[$type_name]);
	}



	/**
	 * @covers Mephex_App_Resource_List::addType
	 * @dataProvider providerOfTypes
	 * @depends testClassIsInstantiable
	 */
	public function testResourceArrayIsInitedForAddedType($type_name, $class_name)
	{
		$this->_list->addType($type_name, $class_name);
		$resources	= $this->readAttribute(
			$this->_list,
			'_resources'
		);

		$this->assertTrue(is_array($resources[$type_name]));
	}



	/**
	 * @covers Mephex_App_Resource_List::addType
	 * @dataProvider providerOfTypes
	 * @depends testClassIsInstantiable
	 */
	public function testReflectionClassIsAddedForType($type_name, $class_name)
	{
		$this->_list->addType($type_name, $class_name);
		$reflections	= $this->readAttribute(
			$this->_list,
			'_type_class_reflections'
		);

		$this->assertInstanceOf(
			'Mephex_Reflection_Class',
			$reflections[$type_name]
		);
		$this->assertEquals($class_name, $reflections[$type_name]->getName());
	}



	/**
	 * @covers Mephex_App_Resource_List::addType
	 * @depends testClassIsInstantiable
	 */
	public function testReflectionClassIsSharedBetweenTypes()
	{
		$this->_list->addType('http', 'Mephex_App_Arguments');
		$this->_list->addType('cli', 'Mephex_App_Arguments');

		$reflections	= $this->readAttribute(
			$this->_list,
			'_type_class_reflections'
		);

		$this->assertSame(
			$reflections['http'],
			$reflections['cli']
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::addType
	 * @dataProvider providerOfTypes
	 * @depends testClassIsInstantiable
	 * @expectedException Mephex_App_Resource_Exception_DuplicateType
	 */
	public function testTypeCannotBeAddedTwice($type_name, $class_name)
	{
		$this->_list->addType($type_name, $class_name);
		$this->_list->addType($type_name, $class_name);
	}



	public function providerOfTypes()
	{
		return array(
			array(
				'config',
				'Mephex_Config_OptionSet',
			),
			array(
				'args',
				'Mephex_App_Arguments',
			),
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::checkType
	 * @depends testClassIsInstantiable
	 * @depends testReflectionClassIsAddedForType
	 * @expectedException Mephex_App_Resource_Exception_UnknownType
	 */
	public function testTypeMustBeAddedBeforeTypeCanBeChecked()
	{
		$this->_list->checkType('config', 'Mephex_App_Arguments');
	}



	/**
	 * @covers Mephex_App_Resource_List::checkType
	 * @depends testClassIsInstantiable
	 */
	public function testResourceTypeCanBeChecked()
	{
		$this->_list->addType('config', 'Mephex_Config_OptionSet');

		$this->assertEquals(
			'Mephex_Config_OptionSet',
			$this->_list->checkType('config', 'Mephex_Config_OptionSet')
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::addResource
	 * @depends testClassIsInstantiable
	 * @expectedException Mephex_Reflection_Exception_UnexpectedClass
	 */
	public function testExceptionIsThrownIfResourceTypeCheckFails()
	{
		$this->_list->addType('config', 'Mephex_Config_OptionSet');

		$this->assertEquals(
			'Mephex_Config_OptionSet',
			$this->_list->checkType('config', 'Mephex_App_Arguments')
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::addLoader
	 * @dataProvider providerOfLoaders
	 * @depends testClassIsInstantiable
	 */
	public function testLoaderCanBeAdded(
		$type_name, Mephex_App_Resource_Loader $loader
	)
	{
		$this->_list->addLoader($type_name, $loader);
		$loaders	= $this->readAttribute(
			$this->_list,
			'_loaders'
		);

		$this->assertSame($loader, $loaders[$type_name]);
	}



	/**
	 * @covers Mephex_App_Resource_List::addLoader
	 * @dataProvider providerOfLoaders
	 * @depends testClassIsInstantiable
	 */
	public function testAddTypeIsCalledWhenLoaderIsAdded($type_name, Mephex_App_Resource_Loader $loader)
	{
		$list	= $this->getMock(
			'Mephex_App_Resource_List',
			array('addType')
		);
		$list->expects($this->once())
			->method('addType')
			->with(
				$this->equalTo($type_name),
				$this->equalTo($loader->getResourceClassName())
			);
		
		$list->addLoader($type_name, $loader);
	}



	public function providerOfLoaders()
	{
		return array(
			array(
				'config',
				new Mephex_App_Resource_Loader_ArrayWrapper(
					'Mephex_Config_OptionSet',
					array()
				)
			),
			array(
				'args',
				new Mephex_App_Resource_Loader_ArrayWrapper(
					'Mephex_App_Arguments',
					array()
				)
			),
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::addResource
	 * @depends testClassIsInstantiable
	 * @depends testReflectionClassIsAddedForType
	 * @expectedException Mephex_App_Resource_Exception_UnknownType
	 */
	public function testTypeMustBeAddedBeforeResourceCanBeAdded()
	{
		$this->_list->addResource('config', 'core', new Mephex_App_Arguments());
	}



	/**
	 * @covers Mephex_App_Resource_List::addResource
	 * @depends testClassIsInstantiable
	 * @expectedException Mephex_Reflection_Exception_ExpectedObject
	 */
	public function testAddResourceChecksResourceType()
	{
		$this->_list->addType('config', 'Mephex_Config_OptionSet');
		$this->_list->addResource('config', 'core', new Mephex_App_Arguments());
	}



	/**
	 * @covers Mephex_App_Resource_List::addResource
	 * @depends testClassIsInstantiable
	 */
	public function testAddResourceMethodIsFluent()
	{
		$config	= new Mephex_Config_OptionSet();

		$this->_list->addType('config', 'Mephex_Config_OptionSet');
		$this->assertSame(
			$this->_list,
			$this->_list->addResource('config', 'core', $config)
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::addResource
	 * @covers Mephex_App_Resource_List::getResource
	 * @depends testClassIsInstantiable
	 */
	public function testAddedResourceCanBeRetrieved()
	{
		$config	= new Mephex_Config_OptionSet();

		$this->_list->addType('config', 'Mephex_Config_OptionSet');
		$this->_list->addResource('config', 'core', $config);

		$this->assertSame($config, $this->_list->getResource('config', 'core'));
	}



	/**
	 * @covers Mephex_App_Resource_List::getResource
	 * @depends testClassIsInstantiable
	 * @depends testReflectionClassIsAddedForType
	 * @expectedException Mephex_App_Resource_Exception_UnknownType
	 */
	public function testTypeMustBeAddedBeforeResourceCanBeRetrieved()
	{
		$this->_list->getResource('config', 'core');
	}



	/**
	 * @covers Mephex_App_Resource_List::loadResource
	 * @depends testClassIsInstantiable
	 * @depends testLoaderCanBeAdded
	 * @expectedException Mephex_App_Resource_Exception_UnknownLoader
	 */
	public function testAttemptingToLoadResourceForTypeWithoutLoaderThrowsException()
	{
		$this->_list->addType('config', 'Mephex_Config_OptionSet');
		$this->_list->loadResource('config', 'core');
	}



	/**
	 * @covers Mephex_App_Resource_List::loadResource
	 * @depends testClassIsInstantiable
	 * @depends testLoaderCanBeAdded
	 */
	public function testResourceCanBeLoaded()
	{
		$primary	= new Mephex_Config_OptionSet();
		$secondary	= new Mephex_Config_OptionSet();
		$this->_list->addLoader(
			'config',
			new Mephex_App_Resource_Loader_ArrayWrapper(
				'Mephex_Config_OptionSet',
				array(
					'core'	=> $primary,
					'2nd'	=> $secondary
				)
			)
		);

		$this->assertSame(
			$primary,
			$this->_list->loadResource('config', 'core')
		);

		$this->assertSame(
			$secondary,
			$this->_list->loadResource('config', '2nd')
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::getResource
	 * @depends testClassIsInstantiable
	 * @depends testResourceCanBeLoaded
	 */
	public function testResourceIsLoadedIfNotAlreadyAdded()
	{
		$primary	= new Mephex_Config_OptionSet();
		$secondary	= new Mephex_Config_OptionSet();
		$this->_list->addLoader(
			'config',
			new Mephex_App_Resource_Loader_ArrayWrapper(
				'Mephex_Config_OptionSet',
				array(
					'core'	=> $primary,
					'2nd'	=> $secondary
				)
			)
		);

		$this->assertSame(
			$primary,
			$this->_list->getResource('config', 'core')
		);
		$this->assertSame(
			$secondary,
			$this->_list->getResource('config', '2nd')
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::getResource
	 * @depends testClassIsInstantiable
	 * @depends testResourceCanBeLoaded
	 */
	public function testResourceIsLoadedIfAndOnlyIfNotAlreadyAdded()
	{
		$primary	= new Mephex_Config_OptionSet();
		$secondary	= new Mephex_Config_OptionSet();
		$this->_list->addLoader(
			'config',
			new Mephex_App_Resource_Loader_ArrayWrapper(
				'Mephex_Config_OptionSet',
				array(
					'core'	=> $primary,
					'2nd'	=> $secondary
				)
			)
		);

		$this->_list->addResource('config', 'core', $secondary);
		$this->_list->addResource('config', '2nd', $primary);

		$this->assertSame(
			$secondary,
			$this->_list->getResource('config', 'core')
		);
		$this->assertSame(
			$primary,
			$this->_list->getResource('config', '2nd')
		);
	}



	/**
	 * @covers Mephex_App_Resource_List::getResource
	 * @depends testClassIsInstantiable
	 * @depends testLoaderCanBeAdded
	 * @expectedException Mephex_Reflection_Exception_ExpectedObject
	 */
	public function testLoadedResourceIsTypeChecked()
	{
		$primary	= new Mephex_Config_OptionSet();
		$secondary	= new Mephex_Config_OptionSet();
		$this->_list->addLoader(
			'config',
			new Mephex_App_Resource_Loader_ArrayWrapper(
				'Mephex_App_Arguments',
				array(
					'core'	=> $primary,
					'2nd'	=> $secondary
				)
			)
		);

		$this->_list->getResource('config', 'core');
	}
}