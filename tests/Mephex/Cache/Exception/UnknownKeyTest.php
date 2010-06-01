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
    
    
    
    public function testCacheCanBeRetrieved()
    {
    	$this->assertEquals('some_cache_obj', $this->_exception->getCache());
    }
    
    
    
    public function testKeyCanBeRetrieved()
    {
    	$this->assertEquals('missing_key', $this->_exception->getKey());
    }
}