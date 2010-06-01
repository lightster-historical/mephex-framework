<?php



class Mephex_Model_CacheTest
extends Mephex_Test_TestCase
{
	protected $_cache;
	
	
	
	public function setUp()
	{
		$this->_cache	= new Stub_Mephex_Model_Cache();
	} 
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_cache instanceof Mephex_Model_Cache);
	}
	
	
	
	public function testInternalCacheIsAMephexCacheObject()
	{
		$this->assertTrue($this->_cache->getCache() instanceof Mephex_Cache_Object);
	}
	
	
	
	public function testCacheHasACriteria()
	{
		$internalCache	= $this->_cache->getCache();
		$internalCache->remember("Id:5", 'some_object');
		
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array(array('Id' => 5))));
	}
	
	
	
	public function testFindCriteria()
	{
		$internalCache	= $this->_cache->getCache();
		$internalCache->remember("Id:5", 'some_object');
		
		$criteria	= new Mephex_Model_Criteria_Array(array('Id' => 5));
		$this->assertEquals('some_object', $this->_cache->find($criteria));
	}
}  