<?php



class Mephex_Model_Criteria_StreamReaderTest
extends Mephex_Test_TestCase
{
	protected $_criteria;
	
	
	
	public function setUp()
	{
		$this->_criteria	= new Mephex_Model_Criteria_StreamReader_Id(array('id' => 5), 5);
	}
	
	
	
	public function testAbstractClassIsExtendable()
	{
		$this->assertTrue($this->_criteria instanceof Mephex_Model_Criteria);
		$this->assertTrue($this->_criteria instanceof Mephex_Model_Criteria_StreamReader);
	}
}  