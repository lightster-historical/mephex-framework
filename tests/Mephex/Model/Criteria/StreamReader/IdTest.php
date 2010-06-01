<?php



class Mephex_Model_Criteria_StreamReader_IdTest
extends Mephex_Test_TestCase
{
	protected $_criteria;
	
	
	
	public function setUp()
	{
		$this->_criteria	= new Mephex_Model_Criteria_StreamReader_Id(array('id' => 5), 5);
	}
	
	
	
	public function testStreamReaderDataIsTheSamePassedToTheConstructor()
	{
		$this->assertEquals(array('id' => 5), $this->_criteria->getStreamReaderData());
	}
	
	
	
	public function testIdCriteriaFieldIsAvailable()
	{
		$this->assertTrue($this->_criteria->hasCriteriaFields(array('Id')));
	}
	
	
	
	public function testOtherCriteriaFieldIsNotAvailable()
	{
		$this->assertFalse($this->_criteria->hasCriteriaFields(array('Other')));
	}
	
	
	
	public function testIdCriteriaValueIsTheSameAsPassedToTheConstructor()
	{
		$this->assertEquals(5, $this->_criteria->getCriteriaValue('Id'));
	}
}  