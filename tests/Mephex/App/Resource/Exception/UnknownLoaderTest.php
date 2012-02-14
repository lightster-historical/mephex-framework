<?php



class Mephex_App_Resource_Exception_UnknownLoaderTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_App_Resource_Exception_UnknownLoader::__construct
	 * @expectedException Mephex_App_Resource_Exception_UnknownLoader
	 */
	public function testExceptionIsThrowable()
	{
		throw new Mephex_App_Resource_Exception_UnknownLoader(
			new Mephex_App_Resource_List(),
			'some_type_name',
			'some_resource_name'
		);
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownLoader::getResourceList
	 * @dataProvider providerForGetterTests
	 * @depends testExceptionIsThrowable
	 */
	public function testListCanBeRetrieved(
		$resource_list, $type_name, $resource_name
	)
	{
		$exception	= new Mephex_App_Resource_Exception_UnknownLoader(
			$resource_list,
			$type_name,
			$resource_name
		);
		$this->assertSame($resource_list, $exception->getResourceList());
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownLoader::getTypeName
	 * @dataProvider providerForGetterTests
	 * @depends testExceptionIsThrowable
	 */
	public function testTypeNameCanBeRetrieved(
		$resource_list, $type_name, $resource_name
	)
	{
		$exception	= new Mephex_App_Resource_Exception_UnknownLoader(
			$resource_list,
			$type_name,
			$resource_name
		);
		$this->assertEquals($type_name, $exception->getTypeName());
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownLoader::getResourceName
	 * @dataProvider providerForGetterTests
	 * @depends testExceptionIsThrowable
	 */
	public function testResourceNameCanBeRetrieved(
		$resource_list, $type_name, $resource_name
	)
	{
		$exception	= new Mephex_App_Resource_Exception_UnknownLoader(
			$resource_list,
			$type_name,
			$resource_name
		);
		$this->assertEquals($resource_name, $exception->getResourceName());
	}



	public function providerForGetterTests()
	{
		return array(
			array(new Mephex_App_Resource_List(), 'abc', 'res1'),
			array(new Mephex_App_Resource_List(), '123', 'res9'),
		);
	}
}