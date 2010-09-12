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
	
	
	
	/**
	 * @expectedException Mephex_Model_Criteria_Exception_UnknownKey
	 */
	public function testCheckingCacheForACriteriaWithAnUnknownKeyThrowsAnException()
	{
		$criteria	= new Mephex_Model_Criteria_Array(array('Unknown' => 5));
		$this->_cache->has($criteria);
	}
	
	
	
	public function testFindCriteria()
	{
		$internalCache	= $this->_cache->getCache();
		$internalCache->remember("Id:5", 'some_object');
		
		$criteria	= new Mephex_Model_Criteria_Array(array('Id' => 5));
		$this->assertEquals('some_object', $this->_cache->find($criteria));
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Criteria_Exception_UnknownKey
	 */
	public function testFindCriteriaWithAnUnknownKeyThrowsAnException()
	{
		$criteria	= new Mephex_Model_Criteria_Array(array('Unknown' => 5));
		$this->_cache->find($criteria);
	}
	
	
	
	public function testForgetEntity()
	{
		$entity	= new Stub_Mephex_Model_Entity();
		
		$internalCache	= $this->_cache->getCache();
		$internalCache->remember("Id:5", $entity);
		$internalCache->remember("Id:3", $entity);
		
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array(array('Id' => 5))));
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array(array('Id' => 3))));
		
		$this->_cache->forget(new Stub_Mephex_Model_Entity());
		
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array(array('Id' => 5))));
		$this->assertTrue($this->_cache->has(new Mephex_Model_Criteria_Array(array('Id' => 3))));
		
		$this->_cache->forget($entity);
		
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array(array('Id' => 5))));
		$this->assertFalse($this->_cache->has(new Mephex_Model_Criteria_Array(array('Id' => 3))));
	}
}  