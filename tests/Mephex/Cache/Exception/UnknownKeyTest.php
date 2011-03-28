<?php



class Mephex_Cache_Exception_UnknownKeyTest
extends Mephex_Test_TestCase
{
	protected $_exception;
	
	
	
	public function setUp()
	{
		$this->_exception	= new Mephex_Cache_Exception_UnknownKey('some_cache_obj', 'missing_key');
	}
	
	
	
	/**
	 * @expectedException Mephex_Cache_Exception_UnknownKey
	 */
    public function testCacheUnknownKeyExceptionIsThrowable()
    {
    	throw $this->_exception;
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Exception_UnknownKey::__construct 
	 * @covers Mephex_Cache_Exception_UnknownKey::getCache 
     */
    public function testCacheCanBeRetrieved()
    {
    	$this->assertEquals('some_cache_obj', $this->_exception->getCache());
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Exception_UnknownKey::__construct 
	 * @covers Mephex_Cache_Exception_UnknownKey::getKey 
     */
    public function testKeyCanBeRetrieved()
    {
    	$this->assertEquals('missing_key', $this->_exception->getKey());
    }
}