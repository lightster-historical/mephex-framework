<?php



class Mephex_Config_OptionSetTest
extends Mephex_Test_TestCase
{
	public function getOptionSet()
	{
		return new Stub_Mephex_Config_OptionSet();
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::throwNotFoundException 
	 * @expectedException Mephex_Exception
	 */
	public function testAnUnknownOptionExceptionCanBeThrown()
	{
		$this->getOptionSet()->throwNotFoundException('some_group', 'some_option');
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @depends testAnUnknownOptionExceptionCanBeThrown
	 * @expectedException Mephex_Exception
	 */
	public function testRetrievingAnUnknownOptionThrowsAnExceptionByDefault()
	{
		$this->getOptionSet()->get('unknown_group', 'unknown_option');
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @depends testAnUnknownOptionExceptionCanBeThrown
	 */
	public function testRetrievingAnUnknownOptionCanOptionallyReturnADefaultValue()
	{
		$this->assertEquals(
			'default_value',
			$this->getOptionSet()->get('unknown_group', 'unknown_option', 'default_value')
		);
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @depends testAnUnknownOptionExceptionCanBeThrown
	 */
	public function testRetrievingAnUnknownOptionCanReturnANullDefaultValue()
	{
		$this->assertNull(
			$this->getOptionSet()->get('unknown_group', 'unknown_option', null, false)
		);
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @depends testAnUnknownOptionExceptionCanBeThrown
	 * @expectedException Mephex_Exception
	 */
	public function testAnUnknownOptionExceptionCanBeForcedRegardlessOfTheDefaultValueWhileRetrievingAnUnknownOption()
	{
		$this->getOptionSet()->get('unknown_group', 'unknown_option', 'default_value', true);
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::set
	 */
	public function testOptionsCanBeSet()
	{
		$option_set	= $this->getOptionSet();
		$this->assertTrue($option_set->set('some_GROUP', 'some_OPTION', 'some_value'));
		
		// if these do not throw an exception, we know the option is 
		// no longer unknown (the options were at least somewhat set)
		$option_set->get('some_GROUP', 'some_OPTION');
		// make sure we get here (no exception was thrown)
		$this->assertTrue(true);
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::set
	 * @depends testOptionsCanBeSet
	 */
	public function testOptionsCanBeRetrieved()
	{
		$option_set	= $this->getOptionSet();
		$option_set->set('some_GROUP', 'some_OPTION', 'some_value');
		
		$this->assertEquals('some_value', $option_set->get('some_GROUP', 'some_OPTION'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::set
	 * @depends testOptionsCanBeRetrieved
	 * @depends testOptionsCanBeSet
	 */
	public function testReSettingAnOptionDoesNotOverrideByDefault()
	{
		$option_set	= $this->getOptionSet();
		
		$this->assertTrue($option_set->set('some_group', 'some_option', 'value1'));
		$this->assertEquals('value1', $option_set->get('some_group', 'some_option'));
		
		$this->assertFalse($option_set->set('some_group', 'some_option', 'value2'));
		$this->assertEquals('value1', $option_set->get('some_group', 'some_option'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::set
	 * @depends testOptionsCanBeRetrieved
	 * @depends testOptionsCanBeSet
	 */
	public function testForciblyReSettingAnOptionOverridesAlreadySetOption()
	{
		$option_set	= $this->getOptionSet();
		
		$this->assertTrue($option_set->set('some_group', 'some_option', 'value1'));
		$this->assertEquals('value1', $option_set->get('some_group', 'some_option'));
		
		$this->assertTrue($option_set->set('some_group', 'some_option', 'value2', true));
		$this->assertEquals('value2', $option_set->get('some_group', 'some_option'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::isOptionPreviouslyNotFound
	 * @depends testOptionsCanBeRetrieved
	 */
	public function testUnknownOptionsAreCachedAsNotFound()
	{
		$option_set	= $this->getOptionSet();
		
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
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::addLoader
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::loadGroupOptions
	 * @depends testOptionsCanBeRetrieved
	 */
	public function testOptionsCanBeLoadedFromGroupLoaders()
	{
		$option_set	= $this->getOptionSet();
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
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::loadGroupOptions
	 * @depends testOptionsCanBeRetrieved
	 * @expectedException Mephex_Exception
	 */
	public function testOptionsCanBeLoadedFromGroupLoadersOnlyIfProvidedGroupMatchesRequestedOptionGroup()
	{
		$option_set	= $this->getOptionSet();
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'in_db2');
		
		$this->assertFalse($option_set->hasOption('in_db', 'option_a'));
		$this->assertFalse($option_set->hasOption('in_db', 'option_b'));
		$this->assertFalse($option_set->hasOption('in_db', 'hmph'));
		
		$this->assertEquals(1, $option_set->get('in_db', 'option_a'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::addLoader
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::loadGenericOptions
	 * @depends testOptionsCanBeRetrieved
	 */
	public function testOptionsCanBeLoadedFromGenericLoaders()
	{
		$option_set	= $this->getOptionSet();
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
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::loadGroupOptions
	 * @covers Mephex_Config_OptionSet::loadGenericOptions
	 * @depends testOptionsCanBeRetrieved
	 * @depends testOptionsCanBeLoadedFromGroupLoaders
	 * @depends testOptionsCanBeLoadedFromGenericLoaders
	 */
	public function testGroupAndGenericLoadersCanBeUsedInConjunction()
	{
		$option_set	= $this->getOptionSet();
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
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @depends testOptionsCanBeRetrieved
	 * @depends testOptionsCanBeLoadedFromGroupLoaders
	 * @depends testOptionsCanBeLoadedFromGenericLoaders
	 */
	public function testGroupOptionsAreLoadedBeforeMainOptions()
	{
		$option_set	= $this->getOptionSet();
		$option_set->addLoader(new Stub_Mephex_Config_Loader());
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'collision');
		
		$this->assertFalse($option_set->hasOption('collision', 'source'));
		
		$this->assertEquals('group', $option_set->get('collision', 'source'));
		$this->assertNotEquals('main', $option_set->get('collision', 'source'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::stackLoader
	 * @covers Mephex_Config_OptionSet::loadGenericOptions
	 * @depends testOptionsCanBeRetrieved
	 * @depends testOptionsCanBeLoadedFromGroupLoaders
	 * @depends testOptionsCanBeLoadedFromGenericLoaders
	 */
	public function testGenericLoaderCanBeAddedToFrontOfList()
	{
		$option_set	= $this->getOptionSet();
		$option_set->addLoader(new Stub_Mephex_Config_Loader());
		$option_set->stackLoader(new Stub_Mephex_Config_GroupLoader());
		
		$this->assertFalse($option_set->hasOption('collision', 'source'));
		
		$this->assertEquals('group', $option_set->get('collision', 'source'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::get
	 * @covers Mephex_Config_OptionSet::stackLoader
	 * @covers Mephex_Config_OptionSet::loadGroupOptions
	 * @depends testOptionsCanBeRetrieved
	 * @depends testOptionsCanBeLoadedFromGroupLoaders
	 * @depends testOptionsCanBeLoadedFromGenericLoaders
	 */
	public function testGroupLoaderCanBeAddedToFrontOfList()
	{
		$option_set	= $this->getOptionSet();
		$option_set->addLoader(new Stub_Mephex_Config_GroupLoader(), 'collision');
		$option_set->stackLoader(new Stub_Mephex_Config_Loader(), 'collision');
		$option_set->stackLoader(new Stub_Mephex_Config_GroupLoader());
		
		$this->assertFalse($option_set->hasOption('collision', 'source'));
		
		$this->assertEquals('main', $option_set->get('collision', 'source'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::hasOption
	 */
	public function testHasOptionReturnsTrueIfTheOptionExists()
	{
		$option_set	= $this->getOptionSet();
		$option_set->addLoader(new Stub_Mephex_Config_Loader());
		$option_set->set('manually_set', 'set_option', 'value');
		
		$this->assertTrue($option_set->hasOption('manually_set', 'set_option'));
	}
	
	
	
	/**
	 * @covers Mephex_Config_OptionSet::hasOption
	 */
	public function testHasOptionReturnsFalseIfTheOptionDoesNotExist()
	{
		$option_set	= $this->getOptionSet();
		$option_set->addLoader(new Stub_Mephex_Config_Loader());
		
		$this->assertFalse($option_set->hasOption('manually_set', 'not_set_option'));
	}
}  