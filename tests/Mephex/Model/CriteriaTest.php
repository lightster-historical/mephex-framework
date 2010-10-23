<?php



class Mephex_Model_CriteriaTest
extends Mephex_Test_TestCase
{
	protected $_criteria;
	
	
	
	public function setUp()
	{
		$this->_criteria	= new Stub_Mephex_Model_Criteria();
	}
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_criteria instanceof Mephex_Model_Criteria);
	}
	
	
	
	public function testGetCriteriaValuesReturnsRequestedValues()
	{
		$this->assertTrue(
			array('a' => 1, 'b' => 2) ===
			$this->_criteria->getCriteriaValues(array('a', 'b'))
		);
		$this->assertFalse(
			array('a' => 1, 'b' => 2) ===
			$this->_criteria->getCriteriaValues(array('b', 'a'))
		);
		$this->assertTrue(
			array('b' => 2, 'a' => 1) ===
			$this->_criteria->getCriteriaValues(array('b', 'a'))
		);
		$this->assertTrue(
			array('c' => 3) ===
			$this->_criteria->getCriteriaValues(array('c'))
		);
		$this->assertTrue(
			array('c' => 3, 'a' => 1, 'b' => 2) ===
			$this->_criteria->getCriteriaValues(array('c', 'a', 'b'))
		);
	}
	
	
	
	/**
	 * @expectedException Mephex_Exception
	 */
	public function testAnExceptionIsThrownWhenRetrievingCriteriaValuesForUnavailableFields()
	{
		$this->_criteria->getCriteriaValues(array('d'));
	}
}  