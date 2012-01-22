<?php



class Mephex_App_Resource_Exception_UnknownResourceTest
extends Mephex_Test_TestCase
{
	protected $_resource_loader;



	public function setUp()
	{
		parent::setUp();

		$this->_resource_loader	= new Mephex_App_Resource_Loader_ArrayWrapper(
			'class_name',
			array(
				'some_resource_name1'	=> 'some_resource_obj1',
				'some_resource_name2'	=> 'some_resource_obj2',
			)
		);
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownResource::__construct
	 * @expectedException Mephex_App_Resource_Exception_UnknownResource
	 */
	public function testExceptionIsThrowable()
	{
		throw new Mephex_App_Resource_Exception_UnknownResource(
			$this->_resource_loader,
			'some_resource_name'
		);
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownResource::getResourceLoader
	 * @dataProvider providerForGetterTests
	 * @depends testExceptionIsThrowable
	 */
	public function testLoaderCanBeRetrieved($resource_name)
	{
		$exception	= new Mephex_App_Resource_Exception_UnknownResource(
			$this->_resource_loader,
			$resource_name
		);
		$this->assertSame($this->_resource_loader, $exception->getResourceLoader());
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownResource::getResourceName
	 * @dataProvider providerForGetterTests
	 * @depends testExceptionIsThrowable
	 */
	public function testResourceNameCanBeRetrieved($resource_name)
	{
		$exception	= new Mephex_App_Resource_Exception_UnknownResource(
			$this->_resource_loader,
			$resource_name
		);
		$this->assertEquals($resource_name, $exception->getResourceName());
	}



	public function providerForGetterTests()
	{
		return array(
			array('abc'),
			array('123'),
		);
	}
}