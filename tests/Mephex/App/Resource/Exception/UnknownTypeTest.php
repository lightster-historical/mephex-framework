<?php



class Mephex_App_Resource_Exception_UnknownTypeTest
extends Mephex_Test_TestCase
{
	/**
	 * @covers Mephex_App_Resource_Exception_UnknownType::__construct
	 * @expectedException Mephex_App_Resource_Exception_UnknownType
	 */
	public function testExceptionIsThrowable()
	{
		throw new Mephex_App_Resource_Exception_UnknownType(
			new Mephex_App_Resource_List(),
			'some_type_name'
		);
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownType::getResourceList
	 * @dataProvider providerForGetterTests
	 * @depends testExceptionIsThrowable
	 */
	public function testListCanBeRetrieved($resource_list, $type_name)
	{
		$exception	= new Mephex_App_Resource_Exception_UnknownType(
			$resource_list,
			$type_name
		);
		$this->assertSame($resource_list, $exception->getResourceList());
	}



	/**
	 * @covers Mephex_App_Resource_Exception_UnknownType::getTypeName
	 * @dataProvider providerForGetterTests
	 * @depends testExceptionIsThrowable
	 */
	public function testTypeNameCanBeRetrieved($resource_list, $type_name)
	{
		$exception	= new Mephex_App_Resource_Exception_UnknownType(
			$resource_list,
			$type_name
		);
		$this->assertEquals($type_name, $exception->getTypeName());
	}



	public function providerForGetterTests()
	{
		return array(
			array(new Mephex_App_Resource_List(), 'abc'),
			array(new Mephex_App_Resource_List(), '123'),
		);
	}
}