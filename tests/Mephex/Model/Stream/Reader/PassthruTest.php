<?php



class Mephex_Model_Stream_Reader_PassthruTest
extends Mephex_Test_TestCase
{
	protected $_reader;
	
	
	
	public function setUp()
	{
		$this->_reader	= new Mephex_Model_Stream_Reader_Passthru('Some_Entity_Class');
	}
	
	
	
	public function testReadingUsingAStreamReaderCriteriaReturnsTheStreamReaderData()
	{
		$criteria	= new Mephex_Model_Criteria_StreamReader_Id(array('id' => 5), 5);
		$this->assertEquals(array('id' => 5), $this->_reader->read($criteria)->current());
	}
	
	
	
	/**
	 * @expectedException Mephex_Model_Stream_Exception_UnexpectedCriteriaType
	 */
	public function testReadingUsingANonStreamReaderCriteriaThrowsAnException()
	{
		$criteria	= new Mephex_Model_Criteria_Array(array('id' => 5));
		$this->_reader->read($criteria);	
	}
}  