<?php



class Mephex_Cache_ObjectTest
extends Mephex_Test_TestCase
{
	protected $_cache;
	
	
	
	public function setUp()
	{
		$this->_cache	= new Mephex_Cache_Object();
	}
	
	
	
	/**
	 * @covers Mephex_Cache_Object::has
	 */
    public function testAnEmptyCacheDoesNotHaveAKey()
    {
    	$this->assertFalse($this->_cache->has('unknown_key'));
    }
    
    
    
	/**
	 * @covers Mephex_Cache_Object::has
	 * @covers Mephex_Cache_Object::remember
	 * @depends testAnEmptyCacheDoesNotHaveAKey
	 */
    public function testACacheHasARememberedKey()
    {
    	$key	= 'some_key';
    	$value	= 123;
    	
    	$this->_cache->remember($key, $value);
    	$this->assertTrue($this->_cache->has($key));
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Object::remember
     * @expectedException Mephex_Cache_Exception_DuplicateKey
     */
    public function testKeysCannotBeRememberedTwice()
    {
    	$key	= 'some_key';
    	$value	= 123;
    	
    	$this->_cache->remember($key, $value);
    	$this->_cache->remember($key, $value + 1);
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Object::remember
	 * @covers Mephex_Cache_Object::find
	 * @depends testACacheHasARememberedKey
     */
    public function testRememberedValuesAreRetrievable()
    {
    	$key	= 'some_key';
    	$value	= 123;
    	
    	$this->_cache->remember($key, $value);
    	$this->assertEquals($this->_cache->find($key), $value);
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Object::find
     * @expectedException Mephex_Cache_Exception_UnknownKey
     */
    public function testSearchingForANonRememberedKeyThrowsAnException()
    {
    	$this->_cache->find('unknown_key');
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Object::forget
     * @depends testACacheHasARememberedKey
     * @depends testRememberedValuesAreRetrievable
     */
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
	 * @covers Mephex_Cache_Object::forget
     * @expectedException Mephex_Cache_Exception_UnknownKey
     */
    public function testForgettingANonRememberedKeyThrowsAnException()
    {
    	$this->_cache->forget('unknown_key');
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Object::forget
     */
    public function testTheExceptionThrownByForgettingANonRememberedKeyCanBeSuppressed()
    {
    	$this->assertFalse($this->_cache->forget('unknown_key', true));
    }
    
    
    
    /**
	 * @covers Mephex_Cache_Object::forgetAll
     * @depends testACacheHasARememberedKey
     */
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
    
    
    
    /**
	 * @covers Mephex_Cache_Object::removeObject
     * @depends testACacheHasARememberedKey
     */
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