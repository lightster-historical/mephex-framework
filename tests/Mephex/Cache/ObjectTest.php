<?php



class Mephex_Cache_ObjectTest
extends Mephex_Test_TestCase
{
	protected $_cache;
	
	
	
	public function setUp()
	{
		$this->_cache	= new Mephex_Cache_Object();
	}
	
	
	
    public function testAnEmptyCacheDoesNotHaveAKey()
    {
    	$this->assertFalse($this->_cache->has('unknown_key'));
    }
    
    
    
    public function testACacheHasARememberedKey()
    {
    	$key	= 'some_key';
    	$value	= 123;
    	
    	$this->_cache->remember($key, $value);
    	$this->assertTrue($this->_cache->has($key));
    }
    
    
    
    /**
     * @expectedException Mephex_Cache_Exception_DuplicateKey
     */
    public function testKeysCannotBeRememberedTwice()
    {
    	$key	= 'some_key';
    	$value	= 123;
    	
    	$this->_cache->remember($key, $value);
    	$this->_cache->remember($key, $value + 1);
    }
    
    
    
    public function testRememberedValuesAreRetrievable()
    {
    	$key	= 'some_key';
    	$value	= 123;
    	
    	$this->_cache->remember($key, $value);
    	$this->assertEquals($this->_cache->find($key), $value);
    }
    
    
    
    /**
     * @expectedException Mephex_Cache_Exception_UnknownKey
     */
    public function testSearchingForANonRememberedKeyThrowsAnException()
    {
    	$this->_cache->find('unknown_key');
    }
    
    
    
    public function testARememberedKeyCanBeForgotten()
    {
    	$key	= 'some_key';
    	$value	= 123;
    	
    	$this->_cache->remember($key, $value);
    	$this->assertEquals($this->_cache->find($key), $value);
    	
    	$this->assertTrue($this->_cache->forget($key));
    	$this->assertFalse($this->_cache->has($key));
    }
    
    
    
    /**
     * @expectedException Mephex_Cache_Exception_UnknownKey
     */
    public function testForgettingANonRememberedKeyThrowsAnException()
    {
    	$this->_cache->forget('unknown_key');
    }
    
    
    
    public function testTheExceptionThrownByForgettingANonRememberedKeyCanBeSuppressed()
    {
    	$this->assertFalse($this->_cache->forget('unknown_key', true));
    }
    
    
    
    public function testAllKeysAndObjectsCanBeForgotten()
    {
    	$values	= array
    	(
    		'key1' => 'value1',
    		'key2' => 'value2',
    		'key3' => 'value3',
    		'key4' => 'value4'
    	);
    	
    	foreach($values as $key => $value)
    	{
    		$this->_cache->remember($key, $value);
    	}
    	
    	foreach($values as $key => $value)
    	{
    		$this->assertTrue($this->_cache->has($key));
    	}
    	
    	$this->_cache->forgetAll();
    	
    	foreach($values as $key => $value)
    	{
    		$this->assertFalse($this->_cache->has($key));
    	}
    }
    
    
    
    public function testObjectCanBeCompletelyRemovedFromCache()
    {
    	$values	= array
    	(
    		'key1' => 'value1',
    		'key2' => 'value2',
    		'key3' => 'value1',
    		'key4' => 'value4'
    	);
    	
    	foreach($values as $key => $value)
    	{
    		$this->_cache->remember($key, $value);
    	}
    	
    	foreach($values as $key => $value)
    	{
    		$this->assertTrue($this->_cache->has($key));
    	}
    	
    	$this->_cache->removeObject('value1');
    	
    	foreach($values as $key => $value)
    	{
    		$this->assertEquals(($value !== 'value1'), $this->_cache->has($key));
    	}
    }
}