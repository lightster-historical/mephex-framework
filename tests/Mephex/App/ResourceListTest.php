<?php



class Mephex_App_ResourceListTest
extends Mephex_Test_TestCase
{
	protected $_resource_list;
	
	
	
	public function setUp()
	{
		$this->_resource_list	= new Stub_Mephex_App_ResourceList();
	}
	
	

	/**
	 * @covers Mephex_App_ResourceList::__construct
	 */
	public function testResourceListIsInstantiable()
	{
		$this->assertTrue(
			$this->_resource_list
			instanceof
			Mephex_App_ResourceList
		);
	}
	
	

	/**
	 * @covers Mephex_App_ResourceList::get
	 * @expectedException Mephex_Cache_Exception_UnknownKey
	 */
	public function testRetrievingNonExistentResourceThrowsException()
	{
		$this->_resource_list->get('missing', 'Mephex_App_Resource');
	}
	
	

	/**
	 * @covers Mephex_App_ResourceList::add
	 * @covers Mephex_App_ResourceList::get
	 */
	public function testResourceCanBeRetrieved()
	{
		$resource	= new Stub_Mephex_App_Resource();
		$this->_resource_list->add('testResource', $resource);

		$this->assertTrue(
			$this->_resource_list->get('testResource', 'Stub_Mephex_App_Resource')
			instanceof
			Stub_Mephex_App_Resource
		);
		$this->assertTrue(
			$this->_resource_list->get('testResource', 'Mephex_App_Resource')
			instanceof
			Mephex_App_Resource
		);
	}
	
	

	/**
	 * @covers Mephex_App_ResourceList::get
	 * @expectedException Mephex_Reflection_Exception_ExpectedObject
	 */
	public function testResourceTypeIsChecked()
	{
		$resource	= new Stub_Mephex_App_Resource();
		$this->_resource_list->add('testResource', $resource);
		$this->_resource_list->get('testResource', 'Mephex_App_ResourceListTest');
	}



	/**
	 * @covers Mephex_App_ResourceList::getReflectionClass
	 */
	public function testReflectionClassIsLazyLoaded()
	{
		$this->assertTrue(
			$this->_resource_list->getReflectionClass('Mephex_App_Resource')
			===
			$this->_resource_list->getReflectionClass('Mephex_App_Resource')
		);
	}
	
	

	/**
	 * @covers Mephex_App_ResourceList::add
	 * @expectedException Mephex_Cache_Exception_DuplicateKey
	 */
	public function testResourceKeysCannotBeReUsed()
	{
		$resource1	= new Stub_Mephex_App_Resource();
		$resource2	= new Stub_Mephex_App_Resource();
		$this->_resource_list->add('testResource', $resource1);
		$this->_resource_list->add('testResource', $resource2);
	}
}