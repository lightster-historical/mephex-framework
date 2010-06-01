<?php



class Mephex_Model_Criteria_ArrayTest
extends Mephex_Test_TestCase
{
	protected $_criteria;
	protected $_criteria_array;
	
	
	
	public function setUp()
	{
		$this->_criteria_array	= array('Id' => 1, 'Parent' => 3);
		$this->_criteria	= new Mephex_Model_Criteria_Array($this->_criteria_array);
	}
	
	
	
	public function testRequiredCriteriaIsPartOfTheAvailableCriteria()
	{
		$this->assertTrue($this->_criteria->hasCriteriaFields(array('Id'))); 
	}
	
	
	
	public function testRequiredCriteriaIsAllOfTheAvailableCriteria()
	{
		$this->assertTrue($this->_criteria->hasCriteriaFields(array('Id', 'Parent'))); 
		$this->assertTrue($this->_criteria->hasCriteriaFields(array('Parent', 'Id'))); 
	}
	
	
	
	public function testRequiredCriteriaIsNotAvailable()
	{
		$this->assertFalse($this->_criteria->hasCriteriaFields(array('Id', 'Unavailable')));
		$this->assertFalse($this->_criteria->hasCriteriaFields(array('Parent', 'StillUnavailable'))); 
	}
	
	
	
	public function testRetrieveAvailableCriteriaValue()
	{
		$this->assertEquals($this->_criteria_array['Id'], $this->_criteria->getCriteriaValue('Id'));
	}
}  