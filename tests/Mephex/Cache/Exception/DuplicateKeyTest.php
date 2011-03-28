<?php


 
class Mephex_Cache_Exception_DuplicateKeyTest
extends Mephex_Test_TestCase
{
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_exception	= new Mephex_Cache_Exception_DuplicateKey('some_cache_obj', 'duplicate_key');
	}
	
	
	
	/**
	 * @expectedException Mephex_Cache_Exception_DuplicateKey
	 */
    public function testCacheDuplicateKeyExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Exception_DuplicateKey::__construct 
	 * @covers Mephex_Cache_Exception_DuplicateKey::getCache 
     */
    public function testCacheCanBeRetrieved()
    {
    	$this->assertEquals('some_cache_obj', $this->_exception->getCache());
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Exception_DuplicateKey::__construct 
	 * @covers Mephex_Cache_Exception_DuplicateKey::getKey 
     */
    public function testKeyCanBeRetrieved()
    {
    	$this->assertEquals('duplicate_key', $this->_exception->getKey());
    }
}