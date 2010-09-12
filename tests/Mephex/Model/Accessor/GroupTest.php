<?php



class Mephex_Model_Accessor_GroupTest
extends Mephex_Test_TestCase
{
	protected $_group;
	protected $_mapper;
	protected $_cache;
	
	
	
	public function setUp()
	{
		$this->_group	= new Stub_Mephex_Model_Accessor_Group();
		$this->_mapper	= new Stub_Mephex_Model_Mapper($this->_group);		
		$this->_cache	= new Stub_Mephex_Model_Cache();		
	} 
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_group instanceof Mephex_Model_Accessor_Group);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Accessor_Exception_UnknownEntityCache
	 */
	public function testRetrievingAnUnregisteredCacheThrowsAnException()
	{
		$this->_group->getCache('unregistered');	
	}
	
	
	
	public function testACacheCanBeRegisteredAndRetrieved()
	{
		$this->_group->registerCache('registered', $this->_cache);
		$this->assertTrue($this->_group->getCache('registered') === $this->_cache);
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Accessor_Exception_DuplicateEntityCache
	 */
	public function testRegisteringTwoCachesForTheSameEntityClassThrowsAnException()
	{
		$this->_group->registerCache('uhoh', $this->_cache);
		$this->_group->registerCache('uhoh', $this->_cache);
	}
	
	
	
	public function testAReaderCanBeRegisteredAndRetrieved()
	{
		$cache	= new Stub_Mephex_Model_Cache();
		$stream	= new Stub_Mephex_Model_Stream_Reader();
		
		$accessor	= new Stub_Mephex_Model_Accessor_Reader(
			$this->_group,
			$this->_mapper,
			$cache,
			$stream
		);
		
		$this->_group->registerAccessor('Accessor', $accessor);
		$this->assertTrue($accessor === $this->_group->getReader('Accessor'));
	}
	
	

	/**
	 * @expectedException Mephex_Model_Accessor_Exception_UnknownReader
	 */
	public function testRetrievingAnUnregisteredReaderAccessorNameThrowsAnException()
	{
		$this->_group->getReader('Unregistered');
	}
	
	
	
	public function testAWriterCanBeRegisteredAndRetrieved()
	{
		$cache	= new Stub_Mephex_Model_Cache();
		$stream	= new Stub_Mephex_Model_Stream_Writer();
		
		$accessor	= new Stub_Mephex_Model_Accessor_Writer(
			$this->_group,
			$this->_mapper,
			$cache,
			$stream
		);
		
		$this->_group->registerAccessor('Accessor', $accessor);
		$this->assertTrue($accessor === $this->_group->getWriter('Accessor'));
	}
	
	

	/**
	 * @expectedException Mephex_Model_Accessor_Exception_UnknownWriter
	 */
	public function testRetrievingAnUnregisteredWriterAccessorNameThrowsAnException()
	{
		$this->_group->getWriter('Unregistered');
	}
	
	
	
	public function testAnEraserCanBeRegisteredAndRetrieved()
	{
		$accessor	= new Stub_Mephex_Model_Accessor_Eraser(
			$this->_group,
			$this->_mapper
		);
		
		$this->_group->registerAccessor('Accessor', $accessor);
		$this->assertTrue($accessor === $this->_group->getEraser('Accessor'));
	}
	
	

	/**
	 * @expectedException Mephex_Model_Accessor_Exception_UnknownEraser
	 */
	public function testRetrievingAnUnregisteredEraserAccessorNameThrowsAnException()
	{
		$this->_group->getEraser('Unregistered');
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Accessor_Exception_InvalidAccessor
	 */
	public function testRegisteringAGenericAccessorThrowsAnException()
	{
		$accessor	= new Stub_Mephex_Model_Accessor(
			$this->_group,
			$this->_mapper
		);
		$this->_group->registerAccessor('Accessor', $accessor);
	}
	
	
	
	/**
	 * @depends testAReaderCanBeRegisteredAndRetrieved
	 */
	public function testAReferenceCanBeGeneratedUsingARegisteredReader()
	{
		$cache	= new Stub_Mephex_Model_Cache();
		$stream	= new Stub_Mephex_Model_Stream_Reader();
		
		$accessor	= new Stub_Mephex_Model_Accessor_Reader(
			$this->_group,
			$this->_mapper,
			$cache,
			$stream
		);
		
		$this->_group->registerAccessor('Accessor', $accessor);
		
		$criteria	= new Stub_Mephex_Model_Criteria();
		
		$reference	= $this->_group->getReference('Accessor', $criteria);
		$this->assertTrue($reference instanceof Mephex_Model_Entity_Reference);
	}
}  