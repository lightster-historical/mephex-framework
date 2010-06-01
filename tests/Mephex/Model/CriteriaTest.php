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
}  