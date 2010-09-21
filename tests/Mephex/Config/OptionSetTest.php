<?php



class Mephex_Config_OptionSetTest
extends Mephex_Test_TestCase
{
	public function getOptionSet($case_sensitive)
	{
		return new Stub_Mephex_Config_OptionSet($case_sensitive);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnUnknownOptionExceptionCanBeThrown()
	{
		$this->getOptionSet(true)->throwNotFoundException('some_group', 'some_option');
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testRetrievingAnUnknownOptionThrowsAnExceptionByDefault()
	{
		$this->getOptionSet(true)->get('unknown_group', 'unknown_option');
	}
	
	
	
	public function testRetrievingAnUnknownOptionCanOptionallyReturnADefaultValue()
	{
		$this->assertEquals(
			'default_value',
			$this->getOptionSet(true)->get('unknown_group', 'unknown_option', 'default_value')
		);
	}
	
	
	
	public function testRetrievingAnUnknownOptionCanReturnANullDefaultValue()
	{
		$this->assertNull(
			$this->getOptionSet(true)->get('unknown_group', 'unknown_option', null, false)
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnUnknownOptionExceptionCanBeForcedRegardlessOfTheDefaultValueWhileRetrievingAnUnknownOption()
	{
		$this->getOptionSet(true)->get('unknown_group', 'unknown_option', 'default_value', true);
	}
	
	
	
	public function testCaseInsensitiveKeysCanBeCanonicalized()
	{
		$option_set	= $this->getOptionSet(false);
		
		$group		= 'aAbBcC';
		$option		= 'XxYyZz';
		$option_set->canonicalizeKeys($group, $option);
		
		$this->assertEquals('aabbcc', $group);
		$this->assertEquals('xxyyzz', $option);
	}
	
	
	
	public function testCaseSensitiveKeysCanBeCanonicalize()
	{
		$option_set	= $this->getOptionSet(true);
		
		$group		= 'aAbBcC';
		$option		= 'XxYyZz';
		$option_set->canonicalizeKeys($group, $option);
		
		$this->assertEquals('aAbBcC', $group);
		$this->assertEquals('XxYyZz', $option);
	}
	
	
	
	public function testOptionsCanBeSet()
	{
		$option_set	= $this->getOptionSet(false);
		$this->assertTrue($option_set->set('some_GROUP', 'some_OPTION', 'some_value'));
		
		// if these do not throw an exception, we know the option is 
		// no longer unknown (the options were at least somewhat set)
		$option_set->get('some_GROUP', 'some_OPTION');
		$option_set->get('some_GROUP', 'some_option');
		$option_set->get('some_group', 'some_OPTION');
		$option_set->get('some_group', 'some_option');
		// make sure we get here (no exception was thrown)
		$this->assertTrue(true);
	}
	
	
	
	/**
	 * @depends testOptionsCanBeSet
	 */
	public function testOptionsCanBeRetrieved()
	{
		$option_set	= $this->getOptionSet(false);
		$option_set->set('some_GROUP', 'some_OPTION', 'some_value');
		
		$this->assertEquals('some_value', $option_set->get('some_GROUP', 'some_OPTION'));
		$this->assertEquals('some_value', $option_set->get('some_GROUP', 'some_option'));
		$this->assertEquals('some_value', $option_set->get('some_group', 'some_OPTION'));
		$this->assertEquals('some_value', $option_set->get('some_group', 'some_option'));
	}
	
	
	
	public function testReSettingAnOptionDoesNotOverrideByDefault()
	{
		$option_set	= $this->getOptionSet(true);
		
		$this->assertTrue($option_set->set('some_group', 'some_option', 'value1'));
		$this->assertEquals('value1', $option_set->get('some_group', 'some_option'));
		
		$this->assertFalse($option_set->set('some_group', 'some_option', 'value2'));
		$this->assertEquals('value1', $option_set->get('some_group', 'some_option'));
	}
	
	
	
	public function testForciblyReSettingAnOptionOverridesAlreadySetOption()
	{
		$option_set	= $this->getOptionSet(true);
		
		$this->assertTrue($option_set->set('some_group', 'some_option', 'value1'));
		$this->assertEquals('value1', $option_set->get('some_group', 'some_option'));
		
		$this->assertTrue($option_set->set('some_group', 'some_option', 'value2', true));
		$this->assertEquals('value2', $option_set->get('some_group', 'some_option'));
	}
	
	
	
	public function testUnknownOptionsAreCachedAsNotFound()
	{
		$option_set	= $this->getOptionSet(false);
		
		$this->assertFalse($option_set->isOptionPreviouslyNotFound('some_group', 'some_option'));
		
		try
		{
			$this->assertEquals($option_set->get('some_group', 'some_option'));
		}
		catch(Exception $ex)
		{
			// do nothing
		}
		
		$this->assertTrue($option_set->isOptionPreviouslyNotFound('some_group', 'some_option'));
	}
	
	
	
	public function testOptionsCanBeLoadedFromGroupLoaders()
	{
		$option_set	= $this->getOptionSet(false);
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'in_db');
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'secondary_group');
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'collision');
		
		$this->assertFalse($option_set->hasOption('in_db', 'option_a'));
		$this->assertFalse($option_set->hasOption('in_db', 'option_b'));
		$this->assertFalse($option_set->hasOption('in_db', 'hmph'));
		$this->assertFalse($option_set->hasOption('secondary_group', 'last_minute_loaded'));
		$this->assertFalse($option_set->hasOption('collision', 'source'));
		
		$this->assertEquals(1, $option_set->get('in_db', 'option_a'));
		$this->assertEquals('x', $option_set->get('in_db', 'option_b'));
		$this->assertEquals('boom!', $option_set->get('in_db', 'hmph'));
		$this->assertEquals('yep', $option_set->get('secondary_group', 'last_minute_loaded'));
		$this->assertEquals('group', $option_set->get('collision', 'source'));
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testOptionsCanBeLoadedFromGroupLoadersOnlyIfProvidedGroupMatchesRequestedOptionGroup()
	{
		$option_set	= $this->getOptionSet(false);
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'in_db2');
		
		$this->assertFalse($option_set->hasOption('in_db', 'option_a'));
		$this->assertFalse($option_set->hasOption('in_db', 'option_b'));
		$this->assertFalse($option_set->hasOption('in_db', 'hmph'));
		
		$this->assertEquals(1, $option_set->get('in_db', 'option_a'));
	}
	
	
	
	public function testOptionsCanBeLoadedFromGenericLoaders()
	{
		$option_set	= $this->getOptionSet(false);
		$option_set->addLoader(new Stub_Mephex_Config_Loader());
		
		$this->assertFalse($option_set->hasOption('database', 'main_conn.host'));
		$this->assertFalse($option_set->hasOption('database', 'main_conn.database'));
		$this->assertFalse($option_set->hasOption('database', 'test_conn.host'));
		$this->assertFalse($option_set->hasOption('database', 'test_conn.database'));
		$this->assertFalse($option_set->hasOption('environment', 'environment'));
		$this->assertFalse($option_set->hasOption('environment', 'logging'));
		$this->assertFalse($option_set->hasOption('dev_tools', 'summary_stats'));
		$this->assertFalse($option_set->hasOption('dev_tools', 'profiling'));
		$this->assertFalse($option_set->hasOption('collision', 'source'));
		$this->assertFalse($option_set->hasOption('collision', 'other'));
		
		$this->assertEquals('localhost', $option_set->get('database', 'main_conn.host'));
		$this->assertEquals('some_db', $option_set->get('database', 'main_conn.database'));
		$this->assertEquals('test_host', $option_set->get('database', 'test_conn.host'));
		$this->assertEquals('test_db', $option_set->get('database', 'test_conn.database'));
		$this->assertEquals('testing', $option_set->get('environment', 'environment'));
		$this->assertEquals('true', $option_set->get('environment', 'logging'));
		$this->assertEquals('true', $option_set->get('dev_tools', 'summary_stats'));
		$this->assertEquals('true', $option_set->get('dev_tools', 'profiling'));
		$this->assertEquals('main', $option_set->get('collision', 'source'));
		$this->assertEquals('uncollide', $option_set->get('collision', 'other'));
	}
	
	
	
	public function testGroupAndGenericLoadersCanBeUsedInConjunction()
	{
		$option_set	= $this->getOptionSet(false);
		$option_set->addLoader(new Stub_Mephex_Config_Loader());
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'in_db');
		
		$this->assertFalse($option_set->hasOption('database', 'main_conn.host'));
		$this->assertFalse($option_set->hasOption('database', 'main_conn.database'));
		$this->assertFalse($option_set->hasOption('in_db', 'option_a'));
		$this->assertFalse($option_set->hasOption('in_db', 'option_b'));
		
		$this->assertEquals('localhost', $option_set->get('database', 'main_conn.host'));
		$this->assertEquals('some_db', $option_set->get('database', 'main_conn.database'));
		$this->assertEquals(1, $option_set->get('in_db', 'option_a'));
		$this->assertEquals('x', $option_set->get('in_db', 'option_b'));
	}
	
	
	
	public function testGroupOptionsAreLoadedBeforeMainOptions()
	{
		$option_set	= $this->getOptionSet(false);
		$option_set->addLoader(new Stub_Mephex_Config_Loader());
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'collision');
		
		$this->assertFalse($option_set->hasOption('collision', 'source'));
		
		$this->assertEquals('group', $option_set->get('collision', 'source'));
		$this->assertNotEquals('main', $option_set->get('collision', 'source'));
	}
}  